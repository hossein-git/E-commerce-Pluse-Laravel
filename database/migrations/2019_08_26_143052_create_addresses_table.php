<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     *  HAS POLY MORPHY REL
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('addr_id');
            $table->string('name');
            $table->string('surname');
            $table->string('state');
            $table->string('city');
            $table->string('area')->nullable();
            $table->string('avenue')->nullable();
            $table->string('street')->nullable();
            $table->string('phone_number');
            $table->smallInteger('number');
            $table->string('postal_code');
            $table->morphs('addressable');
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
        Schema::dropIfExists('addresses');
    }
}
