<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingCharge;
use Session;

class ShippingController extends Controller
{
    public function Shipping()
    {
        Session::put('page','shipping');
        $shippingcharge = ShippingCharge::get()->toArray();
        // dd($shippingcharge);
        return view('admin.shipping.shippings')->with(compact('shippingcharge'));
    }
    public function ShippingStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
        }if($data['status']=="Active"){
            $status = 0;
        }else{
            $status = 1;
        }
        ShippingCharge::where('id',$data['shipping_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'shipping_id'=>$data['shipping_id']]);
    }
    public function addEditShipping( $id, Request $request)
    {
        Session::put('page','shipping');
        if ($request->isMethod('post')) {
          $data = $request->all();
        ShippingCharge::where('id',$id)->update(['rate'=>$data['rate']]);
        $message = "Les frais de livraison ont été mis à jour avec succès.";
        return redirect()->back()->with('success_message',$message);
        }
        $title="Modifier le Tarif";
        $shippingDetail = ShippingCharge::where('id',$id)->first();
        return view('admin.shipping.edit-shipping')->with(compact('shippingDetail','title'));
    }
}
