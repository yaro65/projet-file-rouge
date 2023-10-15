<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;


        public static function sections(){
            $getSections = Section::with('categories')->where('status', 1)->get()->toArray();
            return $getSections; 
        }
        // Relation pour la catégorie parente
        public function categories()
        {
            return $this->hasMany('App\models\Category', 'section_id')
                        ->where('parent_id', 0)
                        ->where('status', 1)
                        ->with('subcategories');
        }        
        
}
