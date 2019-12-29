<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('product_id');
            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('brand_id')
                ->on('brands')->onUpdate('cascade')->onDelete('cascade');

            $table->string('product_name');
            $table->string('product_slug')->unique();
            $table->string('sku')->unique();
                //create a column for available or unavailable, and default is active
            $table->boolean('status')->default(1);
                 //if product is unavailable then an available data comes
            $table->date('data_available')->nullable();
            $table->boolean('is_off')->default(0);
            $table->integer('off_price')->default(0);
            $table->boolean('has_size')->default(0);
            $table->integer('buy_price');
            $table->integer('sale_price');
            $table->integer('quantity');
            $table->string('made_in')->nullable();
            $table->decimal('weight')->nullable();
            $table->text('description');
            $table->string('cover',255);
            $table->softDeletes();
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('products');
    }
}
