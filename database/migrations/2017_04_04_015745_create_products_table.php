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
            $table->increments('id');
            $table->string('code',60);
            $table->string('name',60);
            $table->integer('product_type_id')->unsigned();
            $table->decimal('unit_price', 10, 2);
            $table->decimal('unit_sale_price', 10, 2);
            $table->integer('quantity');
            $table->string('quantity_per_unit',60)->nullable()->default(null);
            $table->boolean('discontinue')->default(0);
            $table->string('description',200)->nullable()->default(null);
            $table->integer('branch_id')->unsigned();
            $table->enum('status',['Enabled','Disabled'])->default('Enabled');
            $table->integer('created_by')->unsigned()->nullable()->default(null);
            $table->integer('updated_by')->unsigned()->nullable()->default(null);
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
        Schema::dropIfExists('products');
    }
}
