<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Banner;
use App\Models\Product;

class IndexController extends Controller
{
    public function index()
    {
        $sliderBanners = Banner::where('type','Slider')->where('status',1)->get()->toArray();
        $fixBanners = Banner::where('type','Fix')->where('status',1)->get()->toArray();
        $newProducts = Product::orderBy('id','Desc')->where('status',1)->limit(8)->get()->toArray();
        // dd($newProducts);
        $bestSellers = Product::where(['is_bestseller'=>'Yes','status'=>1])->get()->toArray();
        $discountedProduct = Product::where('product_discount','>',1)->where('status',1)->limit(6)->inRandomOrder()->get()->toArray();
        $featuredProducts = Product::where(['is_featurred'=>'Yes','status'=>1])->limit(6)->get()->toArray();

        // dd($featuredProducts);

        return view('front.index')->with(compact('sliderBanners','fixBanners','newProducts','bestSellers','discountedProduct','featuredProducts'));
    }
}
