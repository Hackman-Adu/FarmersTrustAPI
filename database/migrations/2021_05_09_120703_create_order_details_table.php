<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("order_id");
            $table->string("orderNumber");
            $table->foreign("order_id")->references("id")->on("orders")->onDelete("cascade");
            $table->string("product");
            $table->string("total_price");
            $table->unsignedBigInteger("quantity");
            $table->string("orderType");
            $table->string("location");
            $table->string("phone");
            $table->unsignedBigInteger("rider_id")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
