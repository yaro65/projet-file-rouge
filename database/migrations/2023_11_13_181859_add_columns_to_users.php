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
        Schema::table('users', function (Blueprint $table) {
            $table->string('prenom')->after('name');
            $table->date('date_naissance')->after('prenom');
            $table->string('address')->after('date_naissance');
            $table->string('pays')->after('address');
            $table->string('region')->after('pays');
            $table->string('ville')->after('region');
            $table->string('telephone')->after('ville');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('prenom');
            $table->dropColumn('date_naissace');
            $table->dropColumn('address');
            $table->dropColumn('ville');
            $table->dropColumn('region');
            $table->dropColumn('pays');
            $table->dropColumn('telephone');
        });
    }
};
