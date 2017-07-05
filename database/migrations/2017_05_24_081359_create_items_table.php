<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);  
            $table->string('code_barcode', 60)->nullable()->default(null);
            $table->string('qr_code', 60)->nullable()->default(null);
            $table->string('lot_number', 60)->nullable()->default(null);
            $table->string('sku', 60)->nullable()->default(null);
            $table->date('expire_date')->nullable()->default(null);
            $table->string('image', 200)->nullable()->default(null);
            $table->integer('category_id')->unsigned()->nullable()->default(null);
            $table->integer('measure_id')->unsigned()->nullable()->default(null);
            $table->integer('item_type_id')->unsigned();
            $table->string('sale_description', 200)->nullable()->default(null);
            $table->integer('income_account_id')->unsigned()->nullable()->unsigned();
            $table->integer('expense_account_id')->unsigned()->nullable()->default(null);  
            $table->integer('inventory_account_id')->unsigned()->nullable()->default(null);
            $table->string('purchase_description', 200)->nullable()->default(null);
            $table->decimal('price', 10, 2)->nullable()->default(null);
            $table->decimal('cost', 10, 2)->nullable()->default(null);
            $table->boolean('discontinue')->nullable()->default(null);
            $table->integer('on_hand')->nullable()->default(null);
            $table->date('as_of_date')->nullable()->default(null);
            $table->integer('reorder_point')->nullable()->default(null);     
            $table->integer('branch_id')->unsigned();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');  
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
        Schema::dropIfExists('items');
    }
}
