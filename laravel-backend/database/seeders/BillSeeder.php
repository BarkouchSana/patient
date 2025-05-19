<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Bill;
use App\Infrastructure\Models\EloquentPatient as Patient; // Assurez-vous que le namespace est correct
class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $patient1 = Patient::find(1); // Assurez-vous que le patient avec ID 1 existe

        if ($patient1) {
            Bill::create([
                'patient_id' => $patient1->id,
                'amount' => 120.50,
                'issue_date' => Carbon::parse('2025-01-15'),
                'due_date' => Carbon::parse('2025-01-30'),
                'status' => 'paid',
                'notes' => 'Consultation générale Dr. Martin',
                'pdf_path' => 'sample_bills/F2025-001.pdf',
            ]);
            Bill::create([
                'patient_id' => $patient1->id,
                'amount' => 75.00,
                'issue_date' => Carbon::parse('2025-02-10'),
                'due_date' => Carbon::parse('2025-02-25'),
                'status' => 'paid',
                'notes' => 'Analyse sanguine',
                'pdf_path' => 'sample_bills/F2025-002.pdf',
            ]);
            Bill::create([
                'patient_id' => $patient1->id,
                'amount' => 90.00,
                'issue_date' => Carbon::parse('2025-03-05'),
                'due_date' => Carbon::parse('2025-03-20'),
                'status' => 'pending',
                'notes' => 'Radiographie du genou',
            ]);
             Bill::create([
                'patient_id' => $patient1->id,
                'amount' => 65.00,
                'issue_date' => Carbon::parse('2024-12-15'),
                'due_date' => Carbon::parse('2024-12-30'),
                'status' => 'paid',
                'notes' => 'Vaccination annuelle',
                'pdf_path' => 'sample_bills/F2024-005.pdf',
            ]);
    }
}
}