<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeliveryAddress;


class DeliveryaddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryAddress = [
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Yaro',
                'address' => 'test10',
                'ville' => 'Ouagadougou',
                'rue' => 'kalgonde',
                'codepostal' => 'Bp100',
                'pays' => 'Burkina',
                'telephone' => '57531441',
                'status' => 1,  
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'name' => 'Yaro',
                'address' => 'test10',
                'ville' => 'Bobo',
                'rue' => 'kalgonde',
                'codepostal' => 'Bp100',
                'pays' => 'Burkina',
                'telephone' => '73634829',
                'status' => 1, 
            ],
        ];
        DeliveryAddress::insert($deliveryAddress);
    }
}
