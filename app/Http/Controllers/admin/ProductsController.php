<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use App\Models\Marque;
use App\Models\ProductsAttribute;
use App\Models\ProductsImage;
use Auth;
use Image;
use Session;

class ProductsController extends Controller
{
    public function products()
    {
        Session::put('page','products');
        $adminType = Auth::guard('admin')->user()->type;
        $vendeur_id = Auth::guard('admin')->user()->vendeur_id;
        if($adminType=="vendeur"){
              $vendeurStatus = Auth::guard('admin')->user()->status;
              if($vendeurStatus==0){
                return redirect("mdifier_fournisseur/profile")->with('error_message','Votre compte vendeur n"est pas approuver. Assurer vous que les information de votre boutique, et de votre bank sont bien corecte!');
              }
        }
        $products = Product::with(['section'=>function($query){
            $query->select('id','nom');
        },'category'=>function($query){
            $query->select('id','category_nom');
        }]);

        if($adminType=="vendeur"){
            $products = $products->where('vendeur_id',$vendeur_id);
        }
        $products = $products->get()->toArray();
      
        // // $myArray = null;
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
        }if($data['status']=="Active"){
            $status = 0;
        }else{
            $status = 1;
        }
        Product::where('id',$data['product_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
    }

    public function deleteproduct($id)
    {
           Product::where('id',$id)->delete();
           $message = "Produits supprimer avec succes!";
           return redirect()->back()->with('success_message',$message);
    }

    
    public function addEditProduct(Request $request , $id=null)
    {
        Session::put('page','products');
          if($id==""){
            $title = "Ajouter Product";
            $product = new Product;
            $message = "Product Ajouter avec succes";
          }else{
            $title = "Ajouter Product";
            $product = Product::find($id);
            //  echo "<pre>"; print_r($product); die;
            $message = "Product Modifier  avec succes";
          }

          if ($request->isMethod('post')) {
            $data = $request->all();
            //  echo "<pre>"; print_r(Auth::guard('admin')->user()); die;

             $rules = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^\w+$/',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',

            ];
            $customMessage = [
                'category_id.required' => 'Veillez entrer le nom de la section',
                'product_name.required' => 'Veillez entrer le nom de product',
                'product_name.regex' => 'Le nom  est invalide',
                'product_code.required' => 'Veillez entrer le code du product',
                'product_code.regex' => 'code est invalide',
                'product_price.required' => 'Veillez entrer le price du product',
                'product_price.regex' => 'Le price est invalide',
                'product_color.required' => 'Veillez entrer la color du produit',
                'product_color.regex' => 'La color est invalide',
               
            ];

            $this->validate($request, $rules, $customMessage);
            //enregistre l'image small= 250x250 medium= 500x500 large=1000x1000
            if ($request->hasFile('product_image')) {
                $image_tmp = $request->file('product_image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension(); // Utilisez $image_tmp au lieu de $request->file('image')
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $largeImagePath = 'front/images/product_images/large/' . $imageName;
                    $mediumImagePath = 'front/images/product_images/medium/' . $imageName;
                    $smallImagePath = 'front/images/product_images/small/' . $imageName;
                    Image::make($image_tmp)->resize(1000,1000)->save($largeImagePath); // Utilisez $image_tmp au lieu de $request
                    Image::make($image_tmp)->resize(500,500)->save($mediumImagePath); // Utilisez $image_tmp au lieu de $request
                    Image::make($image_tmp)->resize(250,250)->save($smallImagePath); 

                    $product->product_image = $imageName;

                }
            } 

              // enregistrer videos 
              if ($request->hasFile('product_videos')) {
                $video_tmp = $request->file('product_videos');
                if ($video_tmp->isValid()) {
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = rand(111,99999).'.'.$extension;
                    $videoPath = 'front/videos/product_videos/';
                    $video_tmp->move($videoPath,$videoName);
                    //
                    $product->product_videos = $videoName;


                }
            }



            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->marque_id = $data['marque_id'];
            //recuper les information de ladministrateur connecter 
            $adminType = Auth::guard('admin')->user()->type;
            $vendeur_id = Auth::guard('admin')->user()->vendeur_id;
            $admin_id = Auth::guard('admin')->user()->id;

            $product->admin_type = $adminType; 
            $product->admin_id = $admin_id;
            if ($adminType == "vendeur") {
                $product->vendeur_id = $vendeur_id;
            } else {
                $product->vendeur_id = 0;
            }

            $product->product_name= $data['product_name'];
            $product->product_code =$data['product_code'];
            $product->product_color =$data['product_color'];
            $product->product_price =$data['product_price'];
            $product->product_discount =$data['product_discount'];
            $product->product_weight =$data['product_weight'];
            $product->description =$data['description'];
            $product->meta_title =$data['meta_title'];
            $product->meta_description =$data['meta_description'];
            $product->meta_keywords =$data['meta_keywords'];
            
            if(!empty($data['product_discount'])){
                $data['product_discount'] = 0;
            }
            if(!empty($data['product_weight'])){
                $data['product_weight'] = 0;
            }
            if(!empty($data['is_featurred'])){
                $product->is_featurred =$data['is_featurred'];
            }else{
                $product->is_featurred = 'NO';
            }
            if(!empty($data['is_featurred'])){
                $product->is_featurred =$data['is_featurred'];
            }else{
                $product->is_featurred = 'NO';
            }
            $product->status=1;
            $product->save();
            return redirect('admin/products')->with('success_message', $message);

          }
          //  enregistrer les produits dans la table product




          //get sections with Categories and sub Categories 
          $categories = Section::with('categories')->get()->toArray();
          //prendre tous le marque 
          $marques = Marque::where('status',1)->get()->toArray();
           return view('admin.products.add_edit_product')->with(compact('title','categories','marques','product'));
    }

    public function deleteproductimage($id)
    {
           
           $productImage = Product::select('product_image')->where('id',$id)->first();
           $small_image_Path = 'front/images/product_images/small/';
           $medium_image_Path = 'front/images/product_images/medium/';
           $large_image_Path = 'front/images/product_images/large/';


           if(file_exists($small_image_Path.$productImage->product_image)){
            unlink($small_image_Path.$productImage->product_image);
           }
           if(file_exists($medium_image_Path.$productImage->product_image)){
            unlink($medium_image_Path.$productImage->product_image);
           }
           if(file_exists($large_image_Path.$productImage->product_image)){
            unlink($large_image_Path.$productImage->product_image);
           }

           //suppression
           
           Product::where('id',$id)->update(['product_image'=>'']);
           $message = "Photos supprimer avec succes!";
           return redirect()->back()->with('success_message',$message);
    }

    public function deleteproductVideo($id)
    {
           
           $productVideo = Product::select('product_videos')->where('id',$id)->first();
           $product_video_Path = 'front/videos/product_videos/';

           if(file_exists($product_video_Path.$productVideo->product_videos)){
            unlink($product_video_Path.$productVideo->product_videos);
           }
           //suppression
           
           Product::where('id',$id)->update(['product_videos'=>'']);
           $message = "Videos supprimer avec succes!";
           return redirect()->back()->with('success_message',$message);
    }

    public function addAttributes(Request $request , $id)
    {
        Session::put('page','attributes');
        $product = Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('attributes')->find($id);
            $product = json_decode(json_encode($product),true);
            // dd($product);  
        if ($request->isMethod('post')) {
            $data = $request->all();
            //  echo "<pre>"; print_r($data); die;
            foreach ($data['sku'] as $key => $value){
                if(!empty($value)){

                  //sku dupliquer 
                  $skuCount = ProductsAttribute::where('sku',$value)->count();
                  if($skuCount>0){
                     return redirect()->back()->with('error_message','SKU already exists! S/il vous plait Ajouter un autre SKU!');
                  }

                  //size duppliquer 
                  $sizeCount = ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                  if($sizeCount>0){
                     return redirect()->back()->with('error_message','Size already exists! S/il vous plait Ajouter un autre Size!');
                  }

                    $attribute = new ProductsAttribute;
                    $attribute->product_id=$id;
                    $attribute->sku=$value;
                    $attribute->size=$data['size'][$key];
                    $attribute->price=$data['price'][$key];
                    $attribute->stock=$data['stock'][$key];
                    $attribute->status= 1;
                    $attribute->save();

                }
            }
           return redirect()->back()->with('success_message','Product Attributes has been added success!');
        }
        return view('admin.attributes.add_edit_attributes')->with(compact('product'));
         
    }

    public function updateAttributeStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
        }if($data['status']=="Active"){
            $status = 0;
        }else{
            $status = 1;
        }
        ProductsAttribute::where('id',$data['attribute_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
    }

    public function deleteAttribute($id)
    {
        ProductsAttribute::where('id',$id)->delete();
           $message = "Attributes supprimer avec succes!";
           return redirect()->back()->with('success_message',$message);
    }

    public function EditAttributes(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            foreach ($data['attributeId'] as $key => $attribute) {
                if(!empty($attribute)){
                    ProductsAttribute::where(['id'=>$data['attributeId'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
                    
                }
            }
            return redirect()->back()->with('success_message','Product Attributes has been update success!');
        }
    }

    ///image ajout
    public function addImages(Request $request , $id)
    {
        Session::put('page','products');
        $product = Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('images')->find($id);
        if($request->isMethod('post')){
            $data = $request->all();
          if($request->hasFile('images')){
            $images = $request->file('images');
            foreach ($images as $key => $image) {
                //generat imge temp
                $image_tmp = Image::make($image);
                //get image name
                $image_name = $image->getClientOriginalName();
                //get image extension
                $extension = $image->getClientOriginalExtension(); // Utilisez $image_tmp au lieu de $request->file('image')
                $imageName = $image_name.rand(111, 99999) . '.' . $extension;
                $largeImagePath = 'front/images/product_images/large/' . $imageName;
                $mediumImagePath = 'front/images/product_images/medium/' . $imageName;
                $smallImagePath = 'front/images/product_images/small/' . $imageName;
                Image::make($image_tmp)->resize(1000,1000)->save($largeImagePath); // Utilisez $image_tmp au lieu de $request
                Image::make($image_tmp)->resize(500,500)->save($mediumImagePath); // Utilisez $image_tmp au lieu de $request
                Image::make($image_tmp)->resize(250,250)->save($smallImagePath); 

                $image = new ProductsImage;
                $image->product_id = $id;
                $image->image = $imageName;
                $image->status = 1;
                $image->save();
            }
          }
          return redirect()->back()->with('success_message','Product Images has been update success!');
        }
        return view('admin.images.add_images')->with(compact('product'));

    }
    public function updateImageStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
        }if($data['status']=="Active"){
            $status = 0;
        }else{
            $status = 1;
        }
        ProductsImage::where('id',$data['image_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'image_id'=>$data['image_id']]);
    }

    public function deleteImage($id)
    {
           
           $productImage = ProductsImage::select('image')->where('id',$id)->first();
           $small_image_Path = 'front/images/product_images/small/';
           $medium_image_Path = 'front/images/product_images/medium/';
           $large_image_Path = 'front/images/product_images/large/';


           if(file_exists($small_image_Path.$productImage->image)){
            unlink($small_image_Path.$productImage->image);
           }
           if(file_exists($medium_image_Path.$productImage->image)){
            unlink($medium_image_Path.$productImage->image);
           }
           if(file_exists($large_image_Path.$productImage->image)){
            unlink($large_image_Path.$productImage->image);
           }

           //suppression
           
           ProductsImage::where('id',$id)->delete();
           $message = "Photos supprimer avec succes!";
           return redirect()->back()->with('success_message',$message);
    }
}
