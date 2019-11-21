<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_product', function (Blueprint $table) {
            $table->unsignedBigInteger('color_id')->index();
            $table->foreign('color_id')->references('color_id')->on('colors');

            $table->unsignedBigInteger('product_id')->index();
            $table->foreign('product_id')->references('product_id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('color_product', function(Blueprint $table)
//        {
//            $table->dropForeign('color_id');
//            $table->dropForeign('product_id');
//        });
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('color_product');
    }
}
