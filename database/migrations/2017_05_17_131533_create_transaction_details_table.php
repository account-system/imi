<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->integer('item_id')->unsigned()->nullable()->default(null);
            $table->integer('item_description')->nullable()->default(null);
            $table->integer('quantity')->nullable()->default(null);
            $table->decimal('price', 10, 2)->nullable()->default(null);
            $table->decimal('amount', 10, 2)->nullable()->default(null);
            $table->decimal('debit', 10, 2)->nullable()->default(null);
            $table->decimal('credit', 10, 2)->nullable()->default(null);
            $table->string('memo',200)->nullable()->default(null);
            $table->enum('status',['Active','Inactive'])->default('Active');
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
        Schema::dropIfExists('transaction_details');
    }
}
