<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('order_id');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');

            $table->unsignedInteger('employee_id')->nullable();
//            $table->unsignedInteger('payment_id');


            $table->unsignedBigInteger('gift_id')->nullable();
            $table->foreign('gift_id')->references('gift_id')->on('gift_cards')->onDelete('set null');

            $table->smallInteger('order_status')->default(0);
            $table->unsignedBigInteger('track_code')->unique();
            $table->string('client_name');
            $table->string('client_phone');
            $table->string('client_email');
            $table->integer('total_price');
            $table->text('details')->nullable();
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
        Schema::dropIfExists('orders');
        Schema::disableForeignKeyConstraints();
    }
}
