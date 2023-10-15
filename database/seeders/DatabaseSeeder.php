<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // $this -> call(AdminsTableSeeder::class);
        // $this -> call(FournisseursTableSeeder::class);
        // $this -> call(BoutiqueFournisseursTableSeeder::class);
        // $this -> call(PaymentFournisseursTableSeeder::class);
          // $this -> call(SectionTableSeeder::class);
          // $this -> call(CategoryTableSeeder::class);
          // $this -> call(MarqueTableSeeder::class);
        // $this -> call(ProductsTableSeeder::class);
        // $this -> call(ProductsAttributesTableSeeder::class);
        $this -> call(BannersTableSeeder::class);
    }
}
