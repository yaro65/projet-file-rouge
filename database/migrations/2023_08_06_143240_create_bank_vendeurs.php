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
        Schema::create('bank_vendeurs', function (Blueprint $table) {
            $table->id();
            $table->integer('vendeur_id');
            $table->string('nom_du_titulaire_du_compte');
            $table->string('nom_de_la_bank');
            $table->string('numero_de_compte');
            $table->string('bank_ifsc_code');
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
        Schema::dropIfExists('payment_fournisseurs');
    }
};
