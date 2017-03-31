<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',60)->unsigned();
            $table->string('category_type_id',60)->nullable();
            $table->string('barcode',60)->nullable()->default(null);
            $table->string('stock_in',10)->nullable()->default(null);
            $table->string('stock_out',10)->nullable()->default(null);
            $table->interger('quotity')->nullable()->default(null);
            $table->string('detail',200)->nullable()->default(null);
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
        Schema::dropIfExists('category_lists');
    }
}
