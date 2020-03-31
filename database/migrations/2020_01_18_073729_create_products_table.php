<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->unsigned();
            $table->string('name')->index('product_name_indx');
            $table->string('code')->index('product_code_indx');
            $table->string('image')->nullable();
            $table->double('sale_price')->default(0);
            $table->longText('description')->nullable();
            $table->double('quantity')->default(0);
            $table->double('opening_quantity')->default(0);
            $table->double('alert_quantity')->default(0);
            $table->string('vat')->default(0);
            $table->bigInteger('unit_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('currency_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->bigInteger('deleted_by')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('material_categories');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
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
