<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commandes_products', function (Blueprint $table) {
            $table->id();
            $table->integer('commande_id');
            $table->integer('user_id');
            $table->integer('vendeur_id');
            $table->integer('admin_id');
            $table->integer('product_id');
            $table->string('product_name');
            $table->string('product_code');
            $table->string('product_color');
            $table->float('product_price');
            $table->string('product_size');
            $table->integer('product_qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commandes_products');
    }
};
