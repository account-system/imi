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
            $table->integer('item_type_id')->unsigned();
            $table->string('code', 60);
            $table->string('name', 60);
            $table->string('purchase_information', 200);
            $table->decimal('cost', 10, 2)->unsigned()->nullable()->default(null);
            // $table->decimal('average_cost', 10, 2)->unsigned()->nullable()->default(null);
            $table->integer('cogs_account_id')->unsigned()->nullable()->default(null);
            $table->boolean('discontinue')->default(0);
            $table->integer('measure_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('branch_id')->unsigned();
            $table->decimal('price', 10, 2)->unsigned();
            // $table->decimal('average_price', 10, 2)->unsigned()->nullable()->default(null);
            $table->integer('income_account_id')->unsigned();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->integer('inventory_account_id')->unsigned()->nullable()->default(null);
            $table->integer('reorder_point')->unsigned()->nullable()->default(null);
            $table->integer('on_hand')->unsigned()->nullable()->default(null);
            $table->decimal('amount', 10, 2)->unsigned()->nullable()->default(null);
            $table->date('as_of_date')->nullable()->default(null);
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
