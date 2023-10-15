<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsAttribute;

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
        $totalStock = ProductsAttribute::where('product_id',$id)->sum('stock');
        // dd($productDetails);
        return view('front.products.detail')->with(compact('productDetails','categoryDetails','totalStock'));
    }

    public function getproductprice(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'],$data['size']);
            return $getDiscountAttributePrice;

        }
    }

    // public function carosel()
    // {
    //     return view('carrosel');
    // }
}
