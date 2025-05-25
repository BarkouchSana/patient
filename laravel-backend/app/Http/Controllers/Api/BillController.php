<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Bill;
use App\Models\Patient;
use App\Http\Resources\BillResource;
use App\Http\Controllers\Controller;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $firstPatient = Patient::first();
        if (!$firstPatient) {
            return response()->json(['message' => 'Aucun patient trouvé dans la base de données.'], 404);
        }

        $patientId = $firstPatient->id;

        $query = Bill::where('patient_id', $patientId)
                     ->with(['doctor', 'items']); // Eager load doctor and items

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('date_from')) {
            $query->where('issue_date', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->where('issue_date', '<=', $request->date_to);
        }
        
        $sortBy = $request->input('sort_by', 'issue_date');
        $sortDirection = $request->input('sort_direction', 'desc');

        // Mettre à jour les colonnes de tri autorisées si nécessaire (ex: doctor.name)
        // Pour trier par nom de médecin, vous auriez besoin d'un join ou d'une approche plus complexe.
        // Pour l'instant, on garde les colonnes directes de la table bills.
        $allowedSortColumns = ['id', 'issue_date', 'due_date', 'amount', 'status'];
        if ($sortBy === 'doctor_name' && method_exists((new Bill)->doctor(), 'getForeignKeyName')) { // Simple check
            // Pour un tri plus robuste par nom de docteur, un join est préférable
            // $query->join('doctors', 'bills.doctor_id', '=', 'doctors.id')
            //       ->orderBy('doctors.name', $sortDirection)
            //       ->select('bills.*'); // S'assurer de sélectionner les colonnes de bills
            // Pour la simplicité, on ne trie pas par nom de docteur ici sans join complexe
        } elseif (in_array($sortBy, $allowedSortColumns)) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->orderBy('issue_date', 'desc'); // Fallback
        }


        $bills = $query->paginate($request->input('per_page', 10));

        return BillResource::collection($bills);
    }

    public function downloadPdf(Request $request, int $billId)
    {
        $bill = Bill::findOrFail($billId); 

        if ($bill->pdf_path && Storage::disk('public')->exists($bill->pdf_path)) {
            $fileName = 'bill_' . $bill->id . '_' . $bill->issue_date->format('Ymd') . '.pdf';
            $filePath = Storage::disk('public')->path($bill->pdf_path);
            return response()->download($filePath, $fileName);
        }
        
        return response()->json(['message' => 'Aucun PDF disponible ou le fichier est introuvable pour cette facture.'], 404);
    }
}