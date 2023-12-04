<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\CommandesProduct;
use Auth;


class CommandesController extends Controller
{
    public function Commandes($id=null)
    {
        if(empty($id)){
            $commandes = Commande::with('commandes_products')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get()->toArray();
            // dd($commandes);
            return view('front.commandes.commandes')->with(compact('commandes'));    
        }else{
            $commmandeDetails = Commande::with('commandes_products')->where('id',$id)->first()->toArray();
            return view('front.commandes.commande_details')->with(compact('commmandeDetails'));    
        }
       
    }
}
