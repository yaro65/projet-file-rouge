<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BankVendeur;

class PaymentFournisseursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fournisseurRecords = [
            [
                'id' => 1,
                'vendeur_id' => 1,
                'nom_du_titulaire_du_compte' => 'Yaro Mahamadou',
                'nom_de_la_bank' => 'ECO/BANK',
                'numero_de_compte' => '00123456789',
                'bank_ifsc_code' => '25-23-45-01',
            ],
        ];
        BankVendeur::insert($fournisseurRecords); // Utilisation du nom correct du modèle
    }
}
