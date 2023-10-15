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
        Schema::create('boutique_vendeurs', function (Blueprint $table) {
            $table->id();
            $table->integer('vendeur_id');
            $table->string('nom_de_boutique');
            $table->string('adresse_de_boutique');
            $table->string('ville_de_boutique');
            $table->string('secteur_de_boutique');
            $table->string('tell_de_boutique');
            $table->string('email_de_boutique');
            $table->string('photos_de_boutique');
            $table->string('document_de_boutique');
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
        Schema::dropIfExists('boutique_fournisseurs');
    }
};
