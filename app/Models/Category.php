<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public function section()
    {
       return $this->belongsTo('App\Models\Section', 'section_id')->select('id','nom');
    }
    // Relation pour les sous-catégories
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->where('status', 1);
    }
    // Relation pour la catégorie parente
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id')->select(['id','category_nom']);         
    }
    public static function categoryDetails($url)
    {
        $categoryDetails = Category::select('id','parent_id','category_nom', 'url','description')
            ->with(['subcategories'=>function($query){
                $query->select('id','parent_id','category_nom','url','description');
            }])
            ->where('url', $url)
            ->first();

            $catIds = array();
            $catIds[] = $categoryDetails['id'];
        if ($categoryDetails['parent_id']==0) {
             $breadcrumbs = '<li class="is-marked">
             <a href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_nom'].'</a>
         </li>';
        } else{
            $parentCategory = Category::select('category_nom','url',)->where('id',$categoryDetails['parent_id'])->first()->toArray();
            $breadcrumbs = '<li class="is-marked">
            <a href="'.url($parentCategory['url']).'">'.$parentCategory['category_nom'].'</a>
          </li> 
          <li class="is-marked">
            <a href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_nom'].'</a>
        </li>';
        }

    
        if ($categoryDetails) {
            // Initialiser un tableau pour stocker les IDs de catégories
            $catIds = [$categoryDetails->id];
    
            // Parcourir les sous-catégories et ajouter leurs IDs au tableau
            foreach ($categoryDetails->subcategories as $subcat) {
                $catIds[] = $subcat->id;
            }
            $resp = [
                'catIds' => $catIds,
                'categoryDetails' => $categoryDetails->toArray(),
                'breadcrumbs' => $breadcrumbs,
            ];
    
            return $resp;
        } else {
            // Retourner une valeur par défaut ou générer une erreur selon votre besoin
            return null;
        }
    }
    
    
}
