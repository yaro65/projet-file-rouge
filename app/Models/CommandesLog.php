<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandesLog extends Model
{
    use HasFactory;
    public function commandes_products()
    {
        return $this->hasMany('App\Models\CommandesProduct','id','commande_item_id');
    }
    public static function getItemDetails($commande_item_id){
        $getItemDetails = CommandesProduct::where('id',$commande_item_id)->first()->toArray();
        return $getItemDetails;
    }
}
