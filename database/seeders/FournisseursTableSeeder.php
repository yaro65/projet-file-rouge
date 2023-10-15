<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendeur;

class FournisseursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendeurRecords = [
            [
                'id' => 1,
                'nom' => 'Yaro',
                'address' => 'rue-11',
                'ville' => 'Ouaga',
                'secteur' => 'kalgonde',
                'telephone' => '57531441',
                'email' => 'yaronasirou5@gmail.com',
                'status' => 0,  
            ],
        ];
        Vendeur::insert($vendeurRecords);
    }
}
