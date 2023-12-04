<?php
use App\Models\Panier;

  function totalPanierItems(){
    if(Auth::check()){
        $user_id = Auth::user()->id;
    $totalPanierItems = Panier::where('user_id',$user_id)->sum('quantity');
    }else{
    $session_id = Session::get('session_id');
    $totalPanierItems = Panier::where('session_id',$session_id)->sum('quantity');
  }
  return $totalPanierItems;

}

  function getPanierItems(){
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