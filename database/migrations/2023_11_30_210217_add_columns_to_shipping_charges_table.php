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
        Schema::table('shipping_charges', function (Blueprint $table) {
            $table->string('0_500g')->after('pays');
            $table->string('501_1000g')->after('0_500g');
            $table->string('1001_2000g')->after('501_1000g');
            $table->string('2001_5000g')->after('1001_2000g');
            $table->string('above_5000g')->after('2001_5000g');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_charges', function (Blueprint $table) {
            //
        });
    }
};
