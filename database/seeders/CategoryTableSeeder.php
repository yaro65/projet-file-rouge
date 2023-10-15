<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryRecords = [
            [
                'id' => 1,
                'parent_id' => 0,
                'section_id' =>  1,
                'category_nom' => 'Men',
                'category_image' => '',
                'category_remise' => 0,
                'description' => '',
                'url' => 'homme',  
                'grand_titre' => '',
                'grand_description' => '',
                'grand_mots_cle' => '', 
                'status' => 1, 
            ],
            
            [
                'id' => 2,
                'parent_id' => 0,
                'section_id' =>  1,
                'category_nom' => 'Women',
                'category_image' => '',
                'category_remise' => 0,
                'description' => '',
                'url' => 'femme',  
                'grand_titre' => '',
                'grand_description' => '',
                'grand_mots_cle' => '', 
                'status' => 1, 
            ],

            [
                'id' => 3,
                'parent_id' => 0,
                'section_id' =>  1,
                'category_nom' => 'Kids',
                'category_image' => '',
                'category_remise' => 0,
                'description' => '',
                'url' => 'enfant',  
                'grand_titre' => '',
                'grand_description' => '',
                'grand_mots_cle' => '', 
                'status' => 1,  
            ],   
       ];
         Category::insert($categoryRecords);
    }
}
