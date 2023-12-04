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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name');
            $table->string('ville');
            $table->string('pays');
            $table->string('rue');
            $table->string('codepostale');
            $table->string('telephone');
            $table->string('email');
            $table->float('shipping_charge');
            $table->string('coupon_code');
            $table->float('coupon_amount');
            $table->string('commande_status');
            $table->string('payment_method');
            $table->string('payment_gateway');
            $table->float('grand_total');
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
        Schema::dropIfExists('commandes');
    }
};
