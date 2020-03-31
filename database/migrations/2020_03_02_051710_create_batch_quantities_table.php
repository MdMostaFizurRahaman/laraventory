<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchQuantitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_quantities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('production_id')->default(0);
            $table->bigInteger('product_id')->default(0);
            $table->double('input_quantity');
            $table->double('batch_quantity');
            $table->double('product_quantity');
            $table->bigInteger('created_by')->default(0);
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
        Schema::dropIfExists('batch_quantities');
    }
}
