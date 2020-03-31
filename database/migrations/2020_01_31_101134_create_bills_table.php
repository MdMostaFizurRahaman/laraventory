<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bill_number');
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('supplier_id')->unsigned();
            $table->bigInteger('currency_id')->unsigned();
            $table->bigInteger('purchase_id')->unsigned();
            $table->bigInteger('account_id')->unsigned();
            $table->string('reference')->nullable();
            $table->date('bill_date')->nullable();
            $table->date('due_date')->nullable();
            $table->double('total')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->string('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->bigInteger('deleted_by')->unsigned()->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('purchase_id')->references('id')->on('purchases');
            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
