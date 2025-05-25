<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bill;
use App\Models\BillItem;

class BillItemSeeder extends Seeder
{
    public function run()
    {
        $bills = Bill::all();
        
        $serviceItems = [
            'Consultation - Nouveau patient' => 50.00,
            'Consultation - Patient existant' => 35.00,
            'Consultation - Spécialiste' => 80.00,
            'Examen médical annuel' => 70.00,
            'Visite de suivi' => 30.00,
            'Analyse de sang - Panel de base' => 25.00,
            'Analyse de sang - Panel complet' => 60.00,
            'Radio - Vue unique' => 45.00,
            'Radio - Vues multiples' => 65.00,
            'IRM' => 250.00,
            'Scanner' => 180.00,
            'Échographie' => 90.00,
            'ECG' => 40.00,
            'Vaccination - Grippe' => 15.00,
            'Vaccination - Tétanos' => 20.00,
            'Administration de médicament' => 10.00,
            'Thérapie par IV' => 55.00,
            'Petite procédure chirurgicale' => 120.00,
            'Application d\'un plâtre' => 75.00,
            'Séance de kinésithérapie' => 45.00,
            'Conseil nutritionnel' => 30.00,
            'Évaluation de santé mentale' => 60.00,
            'Procédure dermatologique' => 85.00,
            'Test d\'allergie' => 70.00,
            'Spirométrie/Test de fonction pulmonaire' => 50.00
        ];

        foreach ($bills as $bill) {
            // Ajouter entre 1 et 5 éléments à chaque facture
            $numItems = rand(1, 5);
            
            // Pour suivre le montant total
            $totalBillAmount = 0;
            
            for ($i = 0; $i < $numItems; $i++) {
                // Sélectionner un service aléatoire
                $serviceName = array_rand($serviceItems);
                $basePrice = $serviceItems[$serviceName];
                
                // Générer une quantité (généralement 1, mais parfois plus pour certains services)
                $quantity = ($serviceName === 'Séance de kinésithérapie' || $serviceName === 'Thérapie par IV' || $serviceName === 'Administration de médicament') ? rand(1, 3) : 1;
                
                // Calculer le prix total
                $totalPrice = $basePrice * $quantity;
                
                // Ajouter au total de la facture
                $totalBillAmount += $totalPrice;
                
                BillItem::create([
                    'bill_id' => $bill->id,
                    'name' => $serviceName,
                    'quantity' => $quantity,
                    'unit_price' => $basePrice,
                    'total_price' => $totalPrice,
                    'created_at' => $bill->created_at,
                    'updated_at' => $bill->created_at
                ]);
            }
            
            // Mettre à jour le montant total de la facture pour qu'il corresponde aux éléments
            $bill->update(['amount' => $totalBillAmount]);
        }
    }
}