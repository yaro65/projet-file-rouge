<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Coupon;
use App\Models\Category;
use App\Models\User;
use App\Models\Marque;
use App\Models\Section;
use Session;
use Auth;


class CouponsController extends Controller
{
    public function Coupons()
    {
        Session::put('page','coupons');
        $adminType = Auth::guard('admin')->user()->type;
        $vendeur_id = Auth::guard('admin')->user()->vendeur_id;
        if($adminType=="vendeur"){
              $vendeurStatus = Auth::guard('admin')->user()->status;
              if($vendeurStatus==0){
                return redirect("mdifier_fournisseur/profile")->with('error_message','Votre compte vendeur n"est pas approuver. Assurer vous que les information de votre boutique, et de votre bank sont bien corecte!');
              }
              $coupons = Coupon::where('vendeur_id',$vendeur_id)->get()->toArray();
        }else{
            $coupons = Coupon::get()->toArray();
        }
        return view("admin.coupons.coupons")->with(compact("coupons"));
    }
    public function updateCouponStatus(Request $request)
    {
   
        if($request->ajax()){
         $data = $request->all();
         
              if($data['status']=="Active"){
                  $status = 0;
              }else{
                  $status = 1;
              }
              Coupon::where('id',$data['coupon_id'])->update(['status'=>$status]);
              return response()->json(['status'=>$status,'coupon_id'=>$data['coupon_id']]);
        }
   }
    public function deletecoupon($id)
    {
           Coupon::where('id',$id)->delete();
           $message = "Coupon supprimer avec succes!";
           return redirect()->back()->with('success_message',$message);
    }

    public function addEditCoupon(Request $request , $id=null)
    {
        Session::put('page','coupons');
        if($id==""){
          $title = "Ajouter coupon";
          $coupon = new Coupon;
          $selPanier = array();
          $selUser = array();
          $selMarque = array();
          $message = "Coupon Ajouter avec succes";
        }else{
          $title = "Mis à jour du coupon";
          $coupon = Coupon::find($id);
          $selPanier = explode(',', $coupon['categories']);
          $selUser = explode(',', $coupon['users']);
          $selMarque = explode(',', $coupon['marques']);
          
          //  echo "<pre>"; print_r($Coupon); die;
          $message = "Coupon Modifier  avec succes";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'categories' => 'required',
                'marques' => 'required',
                'coupon_option' => 'required',
                'coupon_type' => 'required',
                'amount_type' => 'required',
                'amount' => 'required|numeric',
                'expiry_date' => 'required',
            ];
            $customMessage = [
                'categories.required' => 'Sélectionner une catégorie',
                'marques.required' => 'Sélectionner la marque',
                'coupon_option.regex' => "Sélectionner l'option du coupon",
                'coupon_type.required' => 'Sélectionner le type de coupon',
                'amount_type.required' => 'Sélectionner le type de montant',
                'amount.required' => 'Entrer le montant',
                'expiry_date.required' => "Entrer la date d'expiration",
               
            ];

            $this->validate($request, $rules, $customMessage);


            if(isset($data['categories'])){
                $categories = implode(",",$data['categories']);
            }else{
                $categories="";
            }
            if(isset($data['marques'])){
                $marques = implode(",",$data['marques']);
            }else{
                $marques="";
            }
            if(isset($data['users'])){
                $users = implode(",",$data['users']);
            }else{
                $users="";
            }
            if($data['coupon_option']=='Automatic'){
                $coupon_code = Str::random(6);
            }else{
                $coupon_code = $data['coupon_code'];
            }
            $adminType = Auth::guard('admin')->user()->type;
            if($adminType=="vendeur"){
                $coupon->vendeur_id = Auth::guard('admin')->user()->vendeur_id;
            }else{
                $coupon->vendeur_id = 0;
            }
        //    echo "<pre>"; print_r($data); die;
            $coupon->Coupon_option = $data['coupon_option'];
            $coupon->Coupon_code = $coupon_code;
            $coupon->categories = $categories;
            $coupon->marques = $marques;
            $coupon->users = $users;
            $coupon->Coupon_type = $data['coupon_type'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->amount = $data['amount'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->status = 1;
            $coupon->save();
            return redirect('admin/coupons')->with('success_message',$message);



        }
           //get sections with Categories and sub Categories 
          $categories = Section::with('categories')->get()->toArray();
          //prendre tous le marque 
          $marques = Marque::where('status',1)->get()->toArray();
          // get all users email
          $users = User::select('email')->where('status',1)->get();
        return view('admin.coupons.add_edit_coupon')->with(compact('title','coupon','message',
        'categories','marques','users','selPanier','selMarque','selUser')); 
    }
}
