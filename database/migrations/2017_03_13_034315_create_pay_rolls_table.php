<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayRollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_rolls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('staff_id');
            $table->integer('regular_rate');
            $table->integer('total_regular_amount');
            $table->integer('ot');
            $table->integer('ot_rate');
            $table->integer('total_ot_amount');
            $table->integer('service_perform');
            $table->integer('benefit');
            $table->integer('total_service_perform');
            $table->string('note');
            $table->integer('other_compensation');
            $table->integer('spouse_minor');
            $table->integer('gross_salary');
            $table->integer('taxable_salary')->nullable();
            $table->integer('tax');
            $table->integer('tax_amount')->nullable();
            $table->integer('salary_tax_amount');
            $table->integer('net_salary');
            $table->integer('total_salary');
            $table->integer('staff_salary');
            $table->integer('final_salary');
            $table->integer('account_type_id');
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('pay_rolls');
    }
}
