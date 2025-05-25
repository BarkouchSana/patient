<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bill;
use App\Models\Patient;
use App\Models\Doctor;
use Carbon\Carbon;

class BillSeeder extends Seeder
{
    public function run()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        
        $statuses = ['pending', 'paid', 'overdue', 'cancelled', 'partially_paid'];
        $paymentMethods = ['credit_card', 'debit_card', 'cash', 'insurance', 'bank_transfer', 'check'];
        
        // Créer des factures pour chaque patient
        foreach ($patients as $patient) {
            // Créer 2-4 factures par patient
            $numBills = rand(2, 4);
            
            for ($i = 0; $i < $numBills; $i++) {
                $doctor = $doctors->random();
                
                $issueDate = Carbon::now()->subDays(rand(1, 180));
                $dueDate = Carbon::parse($issueDate)->addDays(30);
                $amount = rand(2000, 50000) / 100; // 20.00€ - 500.00€
                
                $status = $statuses[array_rand($statuses)];
                $paymentMethod = null;
                $notes = null;
                
                if ($status === 'paid') {
                    $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
                    $notes = 'Paiement reçu le ' . Carbon::parse($issueDate)->addDays(rand(1, 25))->format('d/m/Y');
                } elseif ($status === 'partially_paid') {
                    $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
                    $notes = 'Paiement partiel de ' . number_format(($amount / 2), 2) . '€ reçu. Solde restant dû.';
                } elseif ($status === 'overdue') {
                    $notes = 'Paiement en retard. Second rappel envoyé le ' . Carbon::parse($dueDate)->addDays(15)->format('d/m/Y');
                }
                
                Bill::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'amount' => $amount,
                    'issue_date' => $issueDate,
                    'due_date' => $dueDate,
                    'status' => $status,
                    'payment_method' => $paymentMethod,
                    'notes' => $notes,
                    'pdf_path' => 'bills/facture_' . $patient->id . '_' . ($i + 1) . '.pdf',
                    'created_at' => $issueDate,
                    'updated_at' => $issueDate
                ]);
            }
        }
    }
}