<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockOutsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_outs_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stock_out_id');
            $table->integer('product_id');
            $table->string('product_name',40);
            $table->integer('qty');
            $table->integer('unit_price');
            $table->integer('total');
            $table->string('description',200)->nullable();
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
        Schema::dropIfExists('stock_outs_details');
    }
}
