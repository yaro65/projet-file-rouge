<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable
{
    use HasFactory;
    Protected $guard = 'admin';

    public function fournisseureProfile()
    {
       return $this->belongsTo('App\Models\Vendeur', 'vendeur_id');
    }
    public function fournisseureBoutique()
    {
       return $this->belongsTo('App\Models\BoutiqueVendeur', 'vendeur_id');
    }
    public function fournisseureBank()
    {
       return $this->belongsTo('App\Models\BankVendeur', 'vendeur_id');
    }
}
