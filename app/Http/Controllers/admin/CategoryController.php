<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section;
use Session;
use Image;

class CategoryController extends Controller
{
    public function categories()
    {
        Session::put('page','categories');
        $categories = Category::with(['section','parentcategory'])->get()->toArray();
        // dd($categories);
        $myArray = null;
        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
        }if($data['status']=="Active"){
            $status = 0;
        }else{
            $status = 1;
        }
        Category::where('id',$data['category_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'scategory_id'=>$data['category_id']]);
    }
    
    public function addEditCategory(Request $request, $id=null)
    {
        Session::put('page', 'categories');
    
        if ($id=="") {
            $title = "Ajouter Catégorie";
            $category = new Category; 
            $getCategories = array(); 
            $message = "Catégorie ajoutée avec succès";
        } else {
            $title = "Modifier Catégorie";
            $category = Category::find($id);
                //  echo "<pre>"; print_r($category['category_nom']); die;
            $getCategories = Category::with('subcategories')->where(['parent_id' => 0, 'section_id' => $category->section_id])->get()->toArray();
            $message = "Catégorie modifiée avec succès";
        }
    
        if ($request->isMethod('post')) {
            $data = $request->all();
            //  echo "<pre>"; print_r($data); die;

            $rules = [
                'category_nom' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'url' => 'required',
            ];
            $customMessage = [
                'category_nom.required' => 'Veillez entrer le nom de catégorie',
                'category_nom.regex' => 'Le nom de catégorie est invalide',
                'section_id.required' => 'Sélectionner la  section',
                'url.required' => 'Veillez entrer le url',
            ];

            $this->validate($request, $rules, $customMessage);
              
    
            if ($request->hasFile('category_image')) {
                $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'front/images/category_images/' . $imageName; // Corrigez le chemin de l'image
                    Image::make($image_tmp)->save($imagePath);
                    $category->category_image = $imageName;
                }
            } else {
                $category->category_image = "";
            }
            $category->section_id = $data['section_id'];
            $category->parent_id = $data['parent_id'];
            $category->category_nom = $data['category_nom'];
            $category->category_remise = $data['category_remise'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->grand_titre = $data['grand_titre'];
            $category->grand_description = $data['grand_description'];
            $category->grand_mots_cle = $data['grand_mots_cle'];
            $category->status = 1;
            $category->save();
    
            return redirect('admin/categories')->with('success_message', $message);
        }
      
        $getSections = Section::get()->toArray();
        return view('admin.categories.add_edit_category')->with(compact('title', 'category', 'getSections', 'getCategories'));
    }  // $getcategory = Category::get()->toArray();

    
    public function appendCategoryLevel(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $getCategories = Category::with('subcategories')->where(['parent_id' => 0, 'section_id' => $data['section_id']])->get()->toArray();  // Correction ici
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }

    public function deletecategory($id)
    {
           Category::where('id',$id)->delete();
           $message = "Categories supprimer avec succes!";
           return redirect()->back()->with('success_message',$message);
    }

    public function deletecategoryimage($id)
    {
           
           $categoryImage = Category::select('category_image')->where('id',$id)->first();
           $category_image_Path = 'front/images/category_images/';

           if(file_exists($category_image_Path.$categoryImage->category_image)){
            unlink($category_image_Path.$categoryImage->category_image);
           }

           //suppression
           
           Category::where('id',$id)->update(['category_image'=>'']);
           $message = "Categories supprimer avec succes!";
           return redirect()->back()->with('success_message',$message);
    }
    
}


