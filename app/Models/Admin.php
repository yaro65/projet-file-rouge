<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable
{
    use HasFactory;
    Protected $guard = 'admin';

    public function vendeurProfile()
    {
       return $this->belongsTo('App\Models\Vendeur', 'vendeur_id');
    }
    public function vendeurBoutique()
    {
       return $this->belongsTo('App\Models\BoutiqueVendeur', 'vendeur_id');
    }
    public function vendeurBank()
    {
       return $this->belongsTo('App\Models\BankVendeur', 'vendeur_id');
    }
}
