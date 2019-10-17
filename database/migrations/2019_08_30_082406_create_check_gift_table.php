<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckGiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * **CHECK USER TO PROVIDE USE GIFT CARD TWICE
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_gift', function (Blueprint $table) {
            $table->bigIncrements('check_gift_id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');

            $table->unsignedBigInteger('gift_id');
            $table->foreign('gift_id')->references('gift_id')->on('gift_cards')->onDelete('cascade');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('check_gift');
    }
}
