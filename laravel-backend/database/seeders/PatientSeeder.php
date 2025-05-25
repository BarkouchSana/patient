<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\User;

class PatientSeeder extends Seeder
{
    public function run()
    {
        // Récupérer les utilisateurs créés précédemment (excluant l'admin)
        $users = User::where('email', '!=', 'admin@hospital.com')->get();

        foreach ($users as $user) {
            // Créer un patient lié à chaque utilisateur
            Patient::create([
                'user_id' => $user->id,
                'registration_date' => now()->subDays(rand(10, 365))
            ]);
        }
    }
}