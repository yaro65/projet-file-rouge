<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon;


class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $couponRecords = [
            [
                'id' => 1,
                'vendeur_id' => 0,
                'coupon_option' => 'Manuel',
                'coupon_code' => 'test10',
                'categories' => '1',
                'users' => '',
                'coupon_type' => 'Single',
                'amount_type' => 'pourcentage',
                'amount' => '10',
                'expiry_date' => '2022-12-31',
                'status' => 1,  
            ],
            [
                'id' => 2,
                'vendeur_id' => 7,
                'coupon_option' => 'Manuel',
                'coupon_code' => 'test20',
                'categories' => '1',
                'users' => '',
                'coupon_type' => 'Single',
                'amount_type' => 'pourcentage',
                'amount' => '20',
                'expiry_date' => '2022-12-31',
                'status' => 1,  
            ],
        ];
        Coupon::insert($couponRecords);
    }
}
