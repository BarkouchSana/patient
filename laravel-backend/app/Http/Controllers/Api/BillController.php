<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Bill; // Ou App\Infrastructure\Models\EloquentBill
use App\Http\Resources\BillResource; // Nous allons créer cette ressource
// use Illuminate\Support\Facades\Auth; // Si vous utilisez l'authentification Laravel standard
use App\Http\Controllers\Controller; // Assurez-vous d'importer le bon namespace pour le contrôleur
class BillController extends Controller
{
    public function index(Request $request, int $patientId)
    {
        // TODO: Mettre en place une vraie vérification d'autorisation
        // Pour l'instant, on suppose que si l'ID patient est fourni, c'est autorisé pour la démo.
        // Dans une vraie application, vérifiez que l'utilisateur authentifié
        // a le droit de voir les factures de $patientId.
        // Par exemple: if (Auth::user()->patient_id !== $patientId && !Auth::user()->isAdmin()) {
        // return response()->json(['message' => 'Unauthorized'], 403);
        // }

        $query = Bill::where('patient_id', $patientId)->where('status', 'paid');

        // Filtrage par date d'émission
        if ($request->has('date_from')) {
            $query->where('issue_date', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->where('issue_date', '<=', $request->date_to);
        }

        // Tri
        $sortBy = $request->input('sort_by', 'issue_date'); // Colonne de tri par défaut
        $sortDirection = $request->input('sort_direction', 'desc'); // Direction par défaut

        if (!in_array($sortBy, ['issue_date', 'amount'])) {
            $sortBy = 'issue_date'; // fallback si la colonne de tri n'est pas valide
        }
        if (!in_array(strtolower($sortDirection), ['asc', 'desc'])) {
            $sortDirection = 'desc'; // fallback
        }

        $query->orderBy($sortBy, $sortDirection);

        $bills = $query->paginate($request->input('per_page', 10));

        return BillResource::collection($bills);
    }

    // Méthode pour simuler le téléchargement de PDF
    public function downloadPdf(Request $request, int $billId)
    {
        $bill = Bill::where('status', 'paid')->findOrFail($billId);
        // TODO: Vérifier que l'utilisateur authentifié a accès à cette facture
        // if (Auth::user()->patient_id !== $bill->patient_id && !Auth::user()->isAdmin()) {
        // return response()->json(['message' => 'Unauthorized'], 403);
        // }

        if ($bill->pdf_path) {
            // Dans une vraie application, vous retourneriez le fichier PDF.
            // Storage::download($bill->pdf_path) ou response()->file(...)
            // Pour la démo, nous simulons.
            return response()->json([
                'message' => "Simulation du téléchargement du PDF pour la facture ID: {$bill->id}",
                'path' => $bill->pdf_path,
                'url' => asset('storage/' . $bill->pdf_path) // Assurez-vous que le lien symbolique storage est créé
            ]);
        }
        return response()->json(['message' => 'Aucun PDF disponible pour cette facture.'], 404);
    }
}