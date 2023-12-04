<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CommandesStatus;


class CommandeStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commandeStatusRecords = [
           
                ['id' => 1, 'name' =>'Nouveau','status' =>1],
                ['id' => 2, 'name' =>'En attente','status' =>1],
                ['id' => 3, 'name' =>'Annulé','status' =>1], 
                ['id' => 4, 'name' =>'En cours','status' =>1],
                ['id' => 5, 'name' =>'Expédié','status' =>1],
                ['id' => 6, 'name' =>'Partiellement','status' =>1], 
                ['id' => 7, 'name' =>'Livré','status' =>1], 
                ['id' => 8, 'name' =>'Partiellement livré','status' =>1], 
                ['id' => 9, 'name' =>'Payé','status' =>1]
           
        ];
        CommandesStatus::insert( $commandeStatusRecords);
    }
}
