<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRecords = [
            [
                'id' => 2,
                'nom' => 'Yaro',
                'type' => 'vendeur',
                'vendeur_id' => 0,
                'telephone' => '57531441',
                'email' => 'yaronasirou5@gmail.com',
                'password' => '$2a$10$AatoYNoNZAlVx91lw/tGLuRGIe7sCEYRYW/Q05IId.2vUJscVUKRS',
                'image' => '',
                'status' => 1,
            ],
        ];
        Admin::insert($adminRecords);
    }
    
}
