<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;

class Panier extends Model
{
    use HasFactory;
    public static function getPanierItems()
    {
        if(Auth::check()){
            $getPanierItems = Panier::with(['product'=>function($query){
                $query->select('id','category_id','product_name','product_code','product_color','product_color','product_image');
            }])->orderby('id','Desc')->where('user_id',Auth::user()->id)->get()->toArray();
        } else {  
            $getPanierItems = Panier::with(['product'=>function($query){
                $query->select('id','category_id','product_name','product_code','product_color','product_color','product_image');
            }])->orderby('id','Desc')->where('session_id',Session::get('session_id'))->get()->toArray();
        }
    return $getPanierItems;
    }
   public function product()
   {
    return $this->belongsTo('App\Models\Product', 'product_id');
   }
}
