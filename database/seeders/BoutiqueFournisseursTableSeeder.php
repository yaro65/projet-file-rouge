<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BoutiqueVendeur; // Correction : Utilisation du nom correct du modèle

class BoutiqueFournisseursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $boutiqueFournisseurRecords = [
            [
                'id' => 1,
                'vendeur_id' => 1,
                'nom_de_boutique' => 'Yaro electronique',
                'adresse_de_boutique' => 'echangeur de est',
                'ville_de_boutique' => 'Ouaga',
                'secteur_de_boutique' => 'secteur 12',
                'tell_de_boutique' => '25-13-20-42',
                'email_de_boutique' => 'yaroelectro@gmail.com',
                'photos_de_boutique' => '',
                'document_de_boutique' => '',
            ],
        ];
        BoutiqueVendeur::insert($boutiqueFournisseurRecords); // Utilisation du nom correct du modèle
    }
}

