<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\Panier;
use App\Models\Coupon;
use App\Models\User;
use App\Models\DeliveryAddress;
use App\Models\Country;
use App\Models\Commande;
use App\Models\CommandesProduct;
use App\Models\ShippingCharge;
use Session;
use DB;
use Auth;


class ProductController extends Controller
{
    public function listing(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();


            $url = $data['url'];
            $_GET['sort'] = $data['sort'];
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0){
                $categoryDetails = Category::categoryDetails($url);
                $categoryProducts = Product::with('marque')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
               
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort']=="product_latest"){
                        $categoryProducts->orderby('products.id','Desc');
                    } else if($_GET['sort']=="price_lowest"){
                        $categoryProducts->orderby('products.product_price','Asc');
                    }else if($_GET['sort']=="price_highest"){
                        $categoryProducts->orderby('products.product_price','Desc');
                    }else if($_GET['sort']=="name_z_a"){
                        $categoryProducts->orderby('products.product_name','Desc');
                    }else if($_GET['sort']=="name_a_z"){
                        $categoryProducts->orderby('products.product_name','Asc');
                    }
                }
              
              
                $categoryProducts= $categoryProducts->paginate(3);
                // dd($categoryProducts); 
                return view('front.products.ajax_product_listing')->with(compact('categoryDetails','categoryProducts','url'));
            }else{   
                abort(404);
            } 
        }else{
            $url = \Request::path();

   
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0){
                $categoryDetails = Category::categoryDetails($url);
                $categoryProducts = Product::with('marque')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
               
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort']=="product_latest"){
                        $categoryProducts->orderby('products.id','Desc');
                    } else if($_GET['sort']=="price_lowest"){
                        $categoryProducts->orderby('products.product_price','Asc');
                    }else if($_GET['sort']=="price_highest"){
                        $categoryProducts->orderby('products.product_price','Desc');
                    }else if($_GET['sort']=="name_z_a"){
                        $categoryProducts->orderby('products.product_name','Desc');
                    }else if($_GET['sort']=="name_a_z"){
                        $categoryProducts->orderby('products.product_name','Asc');
                    }
                }
              
              
                $categoryProducts= $categoryProducts->paginate(3);
                // dd($categoryProducts); 
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url'));
            }else{   
                abort(404);
            } 
        }
    // Obtenir l'URI de la route actuelle

    }

    public function detail($id)
    {
        $productDetails = Product::with(['section','category','marque','attributes'=>function($query){
         $query->where('stock','>',0)->where('status',1);
        },'images'])->find($id)->toArray();
        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);
        // Get similar product 
        $similarProducts = Product::with('marque')
        ->where('category_id', $productDetails['category']['id'])
        ->where('id', '!=', $id)
        ->inRandomOrder()
        ->limit(4)
        ->get()
        ->toArray();
            // dd($similarProducts);

            // section recent produite 
            if(empty(Session::get('session_id'))){
                $session_id=md5(uniqid(rand(), true));
            }else{
                $session_id=Session::get('session_id');
            }
            Session::put('session_id',$session_id);
            //insert product in table if not already exist

            $countRecentlyViewedProducts = DB::table('recent_view_produits')->where(['product_id'=>$id,'session_id'=>$session_id])->count();
            if($countRecentlyViewedProducts == 0){
                DB::table('recent_view_produits')->insert(['product_id'=>$id,'session_id'=>$session_id]);
            }
            $recentProductsIds = DB::table('recent_view_produits')->select('product_id')->where('product_id', '!=', $id)->where('session_id', $session_id)->inRandomOrder()->take(4)->pluck('product_id');
            // get recently viewed products 
            $recentProductsIds = Product::with('marque')->whereIn('id',$recentProductsIds)->get()->toArray();
            
        //    dd($recentProductsIds);
        $totalStock = ProductsAttribute::where('product_id',$id)->sum('stock');
        // dd($productDetails);
        return view('front.products.detail')->with(compact('productDetails','categoryDetails','totalStock','similarProducts','recentProductsIds'));
    }

    public function getproductprice(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'],$data['size']);
            return $getDiscountAttributePrice;

        }
    }

    public function Ajouteraupanier(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            // Vérifier le stock du produit
            // dd($data);
            $getProductStock = ProductsAttribute::isStockAvailable($data['product_id'], $data['size']);
            if ($getProductStock < $data['quantity']) {
                return redirect()->back()->with('error_message', 'La quantité requise n\'est pas disponible !');
            }
            // Ajouter le code pour ajouter au panier ici
            //generat session id if not exist 
            $session_id = Session::get('session_id');
            if(empty($session_id)){
                $session_id = Session::getId();
                Session::put('session_id',$session_id);
            }
            // check Product if already exists in the User panier 
            if(Auth::check()){
                // L'utilisateur est connecté
                $user_id = Auth::user()->id;
                $countProducts = Panier::where(['product_id' => $data['product_id'], 'size' => $data['size'], 'user_id' => $user_id])->count();
            } else {
                $user_id = 0;
                $countProducts = Panier::where(['product_id' => $data['product_id'], 'size' => $data['size'], 'session_id' => $session_id])->count();
            }
            if($countProducts>0){
                return redirect()->back()->with('error_message','Le produit existe déjà dans le panier !');
            }
            

            //save product in panier table 
            $item = new Panier;
            $item->session_id = $session_id;
            $item->user_id = $user_id;
            $item->product_id = $data['product_id'];
            $item->size = $data['size'];
            $item->quantity = $data['quantity'];
            $item->save();
            return redirect()->back()->with('success_message','Le produit a été ajouté au panier!
              <a style="text-decoration:underline !important;" href="/panier">Voir le Panier</a>');
            
        }
    }

    public function Panier(Request $request)
    {
        $getPanierItems = Panier::getPanierItems();
        // dd($getPanierItems);
        return view('front.products.panier')->with(compact('getPanierItems'));
      
    }

    public function Panierupdate(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            // get panier detail

            $panierDetails = Panier::find($data['panierid']);

            // get availlable product stok

            $availableStock = ProductsAttribute::select('stock')->where(['product_id'=>$panierDetails['product_id'],'size'=>$panierDetails['size']])->first()->toArray();

            if($data['qty']>$availableStock['stock']){
                $getPanierItems = Panier::getPanierItems();
                return response()->json([
                    'status'=>false,
                    'message'=>"le stock du produits n'est pas disponible",
                    'view'=>(String)View::make('front.products.panier_item')->with(compact('getPanierItems')),
                    'headerview'=>(String)View::make('front.layout.header_panier_items')->with(compact('getPanierItems'))
                ]);
            }

            $availableSize = ProductsAttribute::where(['product_id'=>$panierDetails['product_id'],'size'=>$panierDetails['size'],'status'=>1])->count();

            if($availableSize==0){
                $getPanierItems = Panier::getPanierItems();
                return response()->json([
                    'status'=>false,
                    'message'=>"la taille du produits n'est pas disponible. Veuillez retirer ce produit et en choisir un autre!",
                    'view'=>(String)View::make('front.products.panier_item')->with(compact('getPanierItems')),
                    'headerview'=>(String)View::make('front.layout.header_panier_items')->with(compact('getPanierItems'))
                ]);
            }

            Panier::where('id',$data['panierid'])->update(['quantity'=>$data['qty']]);
            $getPanierItems = Panier::getPanierItems();
            $totalPanierItems = totalPanierItems();
            Session::forget('couponAmount');
            Session::forget('couponCode');
            return response()->json([
                'status'=>true,
                'totalPanierItems'=>$totalPanierItems,
                'view'=>(String)View::make('front.products.panier_item')->with(compact('getPanierItems')),
                'headerview'=>(String)View::make('front.layout.header_panier_items')->with(compact('getPanierItems'))
            ]);
        }
    }

    public function Panierdelete(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            Session::forget('couponAmount');
            Session::forget('couponCode');
            Panier::where('id', $data['panierid'])->delete();
            $getPanierItems = Panier::getPanierItems();
            $totalPanierItems = totalPanierItems();
            return response()->json(['totalPanierItems'=>$totalPanierItems,
             'view' => (string)View::make('front.products.panier_item')->with(compact('getPanierItems')),
            'headerview'=>(String)View::make('front.layout.header_panier_items')->with(compact('getPanierItems'))]);
        }
        
    }
    
    public function ApplyCoupon(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            Session::forget('couponAmount');
            Session::forget('couponCode');
            $getPanierItems = Panier::getPanierItems();
            $totalPanierItems = totalPanierItems();
            $couponCount = Coupon::where('coupon_code',$data['code'])->count();
            if($couponCount==0){
                return response()->json([
                'status'=>'false',
                'message'=>"Le coupon n'est pas valide !",
                'totalPanierItems'=>$totalPanierItems, 
                'view' => (string)View::make('front.products.panier_item')->with(compact('getPanierItems')),
                'headerview'=>(String)View::make('front.layout.header_panier_items')->with(compact('getPanierItems'))
                 ]);
            }else{
                // check the over coupon condition 

                //get coupon details 
                $couponDetails = Coupon::where('coupon_code',$data['code'])->first();


                // check coupon is active 
                if($couponDetails->status==0){
                    $message = "Le coupon n'est pas actif.";
                }

                //check coupon expiry 
                $expiry_date = $couponDetails->expiry_date;
                $current_date = date('Y-m-d');
                if($expiry_date<$current_date){
                    $message = "Ce coupon a expiré!";
                }

                if($couponDetails->coupon_type=="Une seule fois"){
                    $couponCount = Commande::where(['coupon_code'=>$data['code'],'user_id'=>Auth::User()->id])->count();
                    if($couponCount>=1){
                        $message = "Ce code de coupon a déjà été utilisé par vous ";
                    }
                }

                //check if coupon is from selected categories
                // get all selected categories from coupon 
                $catArr = explode(",",$couponDetails->categories);
                $total_amount=0;
                foreach ($getPanierItems as $key => $item){
                    if(in_array($item['product']['category_id'],$catArr)){
                        $message = "Ce code de coupon ne s'applique pas à l'un des produits sélectionnés.";
                    }
                    $attrPrice=Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                    $total_amount = $total_amount + ($attrPrice['final_price']*$item['quantity']);
                }

                // check if coupon is selected user 
                $usersArr = explode(",",$couponDetails->users);
                foreach ($usersArr as $key => $user){
                    $getUserId = User::select('id')->where('email',$user)->first()->toArray();
                    $usersId[] = $getUserId['id'];  
                }

                foreach ($getPanierItems as  $item){
                    if(count($usersArr)>0){
                        if(!in_array($item['user_id'],$usersId)){
                            $message = "Ce code de coupon ne vous est pas destiné. Essayez avec un code de coupon valide. !";
                        } 
                    }
                }

                if ($couponDetails->vendeur_id > 0) {
                    $productIds = Product::select('id')->where('vendeur_id', $couponDetails->vendeur_id)->pluck('id')->toArray();
                    
                    foreach ($getPanierItems as $item) {
                        if (in_array($item['product']['id'], $productIds)) {
                            $message = "Ce code de coupon ne s'applique pas à l'un des produits sélectionnés. veudeur validation";
                        }
                    }
                }
                


                // if error message is there
                if(isset($message)){
                    return response()->json([
                    'status'=>'false',
                    'message'=>$message,
                    'totalPanierItems'=>$totalPanierItems,
                     'view' => (string)View::make('front.products.panier_item')->with(compact('getPanierItems')),
                    'headerview'=>(String)View::make('front.layout.header_panier_items')->with(compact('getPanierItems'))
                     ]);
                }else{
                    //coupon code is correct 
                    if($couponDetails->amount_type=="Fixed"){
                        $couponAmount = $couponDetails->amount;
                    }else{
                        $couponAmount = $total_amount * ($countDetails->amount/100);
                    }
                    $grand_total = $total_amount - $couponAmount;
                    Session::put('couponAmount',$couponAmount);
                    Session::put('couponCode',$data['code']);
                    $message = "Code de coupon appliqué avec succès. Vous bénéficiez d'une réduction";

                    $view = (string)View::make('front.products.panier_item')->with(compact('getPanierItems'));
                    return response()->json([
                    'status'=>true,
                    'message'=>$message,
                    'totalPanierItems'=>$totalPanierItems,
                    'couponAmount'=>$couponAmount,
                    'grand_total'=>$grand_total,
                    'view' => (string)View::make('front.products.panier_item')->with(compact('getPanierItems')),
                    'headerview'=>(String)View::make('front.layout.header_panier_items')->with(compact('getPanierItems'))
                     ]);
                }

            }

        }
    }

    public function Checkout(Request $request)
    {
        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        foreach ($deliveryAddresses as $key => $value) {
            $shippingCharges = ShippingCharge::getShippingCharges($value['pays']);
            $deliveryAddresses[$key]['shipping_charges'] = $shippingCharges;
        }
        // dd($deliveryAddresses);
        $countries = Country::where('status',1)->get()->toArray();
        $getPanierItems = Panier::getPanierItems();
        if(count($getPanierItems)==0){
            $message = "Le panier est vide ! Veuillez ajouter des produits pour passer à la caisse.";
            return redirect('panier')->with('error_message',$message);
        }
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if(empty($data['address_id'])){
                $message = "Veuillez sélectionner l'adresse de livraison!";
                return redirect()->back()->with('error_message',$message);
            }
            if(empty($data['payment_gateway'])){
                $message = "Veuillez sélectionner le mode de paiement";
                return redirect()->back()->with('error_message',$message);
            }
            if(empty($data['accept'])){
                $message = "Veuillez accepter les termes et conditions";
                return redirect()->back()->with('error_message',$message);
            }

            //
            $deliveryAddress = DeliveryAddress::where('id',$data['address_id'])->first()->toArray();
            // dd($deliveryAddress);
            if($data['payment_gateway']=="COD"){
                $payment_method = "PL";
                $commande_status = "Nouveau";
            }else{
                $payment_method = "Paypal";
                $commande_status = "Paiement capturé";
            }
            DB::beginTransaction();

            $total = 0;
            foreach($getPanierItems as $item){ 
                $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                $total = $total + ($getDiscountAttributePrice['final_price'] * $item['quantity']);
            }

            $shipping_charge=0;

            $shipping_charge = ShippingCharge::getShippingCharges($deliveryAddress['pays']);
            $grand_total = $total + $shipping_charge - Session::get('couponAmount');

            Session::put('grand_total',$grand_total);

            $commande = New Commande;
            $commande->user_id = Auth::user()->id;
            $commande->name = $deliveryAddress['name'];
            $commande->address = $deliveryAddress['address'];
            $commande->ville = $deliveryAddress['ville'];
            $commande->pays = $deliveryAddress['pays'];
            $commande->rue = $deliveryAddress['rue'];
            $commande->codepostal = $deliveryAddress['codepostal'];
            $commande->telephone = $deliveryAddress['telephone'];
            $commande->email = Auth::user()->email;
            $commande->shipping_charge = $shipping_charge;
            $commande->coupon_code = Session::get('couponCode');
            $commande->coupon_amount = Session::get('couponAmount');
            $commande->commande_status = $commande_status;
            $commande->payment_method = $payment_method;
            $commande->payment_gateway = $data['payment_gateway'];
            $commande->grand_total = $grand_total;
            $commande->save();
            
            $commande_id = DB::getPdo()->lastInsertId();

            foreach($getPanierItems as $item){
                $panierItem = New CommandesProduct;
                $panierItem->commande_id = $commande_id;
                $panierItem->user_id = Auth::user()->id;
                $getProductDetails = Product::select('product_name','product_code','product_color',
                 'admin_id','vendeur_id')->where('id',$item['product_id'])->first()->toArray();

                 $panierItem->admin_id = $getProductDetails['admin_id'];
                 $panierItem->vendeur_id = $getProductDetails['vendeur_id'];
                 $panierItem->product_id = $item['product_id'];
                 $panierItem->product_code = $getProductDetails['product_code'];
                 $panierItem->product_name = $getProductDetails['product_name'];
                 $panierItem->product_color = $getProductDetails['product_color'];
                 $panierItem->product_size = $item['size'];
                 $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                 $panierItem->product_price = $getDiscountAttributePrice['final_price'];
                 $panierItem->product_qty = $item['quantity'];
                 $panierItem->save();
            }
            Session::put('commande_id',$commande_id);
            DB::commit();

            if($data['payment_gateway']=="COD"){
            $commandeDetails = Commande::with('commandes_products')->where('id',$commande_id)->first()->toArray();
                // send email
                $email = Auth::user()->email;
                $messageData = [
                    'email' => $email,
                    'name' => Auth::user()->name,
                    'commande_id' => $commande_id,
                    'commandeDetails' => $commandeDetails
                ];
                Mail::send('emails.commande',$messageData , function($message)use($email){
                    $message->to($email)->subject('Commande passée - Fasocom.com');
                 });

            }else {
                
            }
            return redirect('thanks');


        }

        $total_price=0;
        foreach ($getPanierItems as $item) {
            $attrPrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
            $total_price = $total_price + $attrPrice['final_price']*$item['quantity'];
        }

        // dd($deliveryAddresses);
        return view('front.products.checkout')->with(compact('deliveryAddresses','countries','getPanierItems','total_price'));
    }

    public function Thanks()
    {
        if(Session::has('commande_id')){
            Panier::where('user_id',Auth::user()->id)->delete();
            return view('front.products.thanks');
        }else{
            return redirect('panier');
        }
        
    }
}
