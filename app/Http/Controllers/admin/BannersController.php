<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Session;
use Image;



class BannersController extends Controller
{
    public function Banners()
    {
        Session::put('page','banners');
        $banners = Banner::get()->toArray();
        // dd($banners);
        return view('admin.banners.banners')->with(compact('banners'));
    }

    public function updateBannerStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
        }if($data['status']=="Active"){
            $status = 0;
        }else{
            $status = 1;
        }
        Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'sbanner_id'=>$data['banner_id']]);
    }

    public function deletebanner($id)
    {
           
           $bannerImage = Banner::where('id',$id)->first();
           $banner_image_Path = 'front/images/banner_images/';

           if(file_exists($banner_image_Path.$bannerImage->image)){
            unlink($banner_image_Path.$bannerImage->image);
           }

           //suppression
           
           Banner::where('id',$id)->delete();
           $message = "Bannièrs supprimer avec succes!";
           return redirect('banners')->with('success_message',$message);
    }

    public function addEditbanner(Request $request , $id=null)
    {
        Session::put('page','banners');
        if ($id=="") {
            $title = "Ajouter Banner";
            $banner = new Banner; 
            $message = "Banner ajoutée avec succès";
        } else {
            $title = "Modifier Banner";
            $banner = Banner::find($id);
                //  echo "<pre>"; print_r($category['category_nom']); die;
            $message = "Banner modifiée avec succès";
        }
        if ($request->isMethod('post')) {
            $data = $request->all();
            //  echo "<pre>"; print_r($data); die;
            $banner->type = $data['type'];
            $banner->link = $data['link'];
            $banner->title = $data['title'];
            $banner->alt = $data['alt'];
            $banner->status = 1;

            if($data['type']=="Slider"){
                $width = "1920";
                $heigth = "750";
            }else if($data['type']=="Fix"){
                $width = "1920";
                $heigth = "400";
            }

            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'front/images/banner_images/' . $imageName; // Corrigez le chemin de l'image
                    Image::make($image_tmp)->resize($width,$heigth)->save($imagePath);
                    $banner->image = $imageName;
                }
            }
            $banner->save();
           return redirect('banners')->with('success_message',$message);

        }
        return view('admin.banners.add_edit_banner')->with(compact('title','banner'));
    }
}
