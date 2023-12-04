<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    public function commandes_products()
    {
        return $this->hasMany('App\Models\CommandesProduct','commande_id');
    }
}
