<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_type_id')->unsigned();
            $table->decimal('amount', 10, 2)->nullable()->default(null);
            $table->dateTime('date');
            $table->string('memo',200)->nullable()->default(null);
            $table->string('reference_number',60)->nullable()->default(null);
            $table->dateTime('due_date')->nullable()->default(null);
            $table->integer('name_id')->unsigned()->nullable()->default(null);
            $table->integer('branch_id')->unsigned();
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
        Schema::dropIfExists('transactions');
    }
}
