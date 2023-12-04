<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryAddress;
use App\Models\Panier;
use App\Models\Country;
use Auth;

class AddressController extends Controller
{
    public function getDeliveryAddress(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            $deliveryAddress = DeliveryAddress::where('id',$data['addressid'])->first()->toArray();
            return response()->json(['address'=>$deliveryAddress]);
        }

    }
    public function saveDeliveryAddress(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            $validator = Validator::make($request->all(),[
                'delivery_name' => 'required|string|max:100',
                'delivery_ville' => 'required|string|max:100',
                'delivery_pays' => 'required|string|max:100',
                'delivery_rue' => 'required|string|max:100',
                'delivery_telephone' => 'required|numeric|min:8',
                'delivery_codepostal' => 'required',
            ],
            [
                'delivery_name.required' => 'Le champ Nom est requis.',
                'delivery_name.string' => 'Le champ Nom doit être une chaîne de caractères.',
                'delivery_name.max' => 'Le champ Nom ne doit pas dépasser 100 caractères.',
                'delivery_ville.required' => 'Le champ Nom est requis.',
                'delivery_ville.string' => 'Le champ Nom doit être une chaîne de caractères.',
                'delivery_ville.max' => 'Le champ Nom ne doit pas dépasser 100 caractères.',
                'delivery_pays.required' => 'Le champ Nom est requis.',
                'delivery_rue.required' => 'Le champ Nom est requis.',
                'delivery_rue.string' => 'Le champ Nom doit être une chaîne de caractères.',
                'delivery_rue.max' => 'Le champ Nom ne doit pas dépasser 100 caractères.',
                'delivery_telephone.required' => 'Le champ Téléphone est requis.',
                'delivery_telephone.numeric' => 'Le champ Téléphone doit être un numéro.',
                'delivery_telephone.digits' => 'Le champ Téléphone doit avoir 8 chiffres minimum.',
                'delivery_codepostal.required' => 'Le champ code postal est requis.',
            ]
        );
            // echo "<pre>"; print_r($data); die;
            if ($validator->passes()) {
                $address['user_id']=Auth::user()->id;
                $address['name']=$data['delivery_name'];
                $address['address']=$data['delivery_address'];
                $address['pays']=$data['delivery_pays'];
                $address['ville']=$data['delivery_ville'];
                $address['rue']=$data['delivery_rue'];
                $address['codepostal']=$data['delivery_codepostal'];
                $address['telephone']=$data['delivery_telephone'];
            if(!empty($data['delivery_id'])){
                DeliveryAddress::where('id', $data['delivery_id'])->update($address);
            }else{
                $address['status']=1;
                DeliveryAddress::create($address);
                // dd($address);
            }
            $deliveryAddresses = DeliveryAddress::deliveryAddresses();
            $getPanierItems = Panier::getPanierItems();
            $countries = Country::where('status',1)->get()->toArray();
            return response()->json([
                'view' => (string)View::make('front.products.checkout')->with(compact('deliveryAddresses', 'countries','getPanierItems'))
            ]);
            }else{
                return response()->json(['type' => 'error', 'errors' => $validator->messages()]);
            }
               
            
       }
    }

    public function removeDeliveryAddress(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();

            DeliveryAddress::where('id', $data['addressid'])->delete();
            $deliveryAddresses = DeliveryAddress::deliveryAddresses();
            $countries = Country::where('status',1)->get()->toArray();
            return response()->json([
                'view' => (string)View::make('front.products.delivery_address')->with(compact('deliveryAddresses', 'countries'))
            ]);
        }
    }
}
