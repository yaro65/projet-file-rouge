<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Marque;


class MarqueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $marqueRecords = [
            
                ['id' => 1, 'nom' =>'Arrow','status' =>1],
                ['id' => 2, 'nom' =>'Gap','status' =>1],
                ['id' => 3, 'nom' =>'Lee','status' =>1], 
                ['id' => 4, 'nom' =>'Samsung','status' =>1],
                ['id' => 5, 'nom' =>'LG','status' =>1],
                ['id' => 6, 'nom' =>'Lenovo','status' =>1], 
                ['id' => 7, 'nom' =>'MI','status' =>1], 
           
        ];
        Marque::insert($marqueRecords);
    }
}
