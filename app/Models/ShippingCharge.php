<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    use HasFactory;
    public static function getShippingCharges($country)
    {
        $getShippingCharges = ShippingCharge::select('rate')->where('pays',$country)->first();
        return $getShippingCharges->rate;
    }
}
