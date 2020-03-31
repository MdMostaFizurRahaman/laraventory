<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pt_number');
            $table->bigInteger('client_id')->default(0);
            $table->bigInteger('branch_id')->default(0);
            $table->string('processing_date')->nullable();
            $table->string('process_completed_date')->nullable();
            $table->string('expected_receive_date')->nullable();
            $table->string('received_date')->nullable();
            $table->bigInteger('received_by')->default(0);
            $table->text('note')->nullable();
            $table->text('rejection_note')->nullable();
            $table->bigInteger('rejected_by')->default(0);
            $table->boolean('status');
            $table->bigInteger('created_by')->default(0);
            $table->bigInteger('updated_by')->default(0);;
            $table->bigInteger('deleted_by')->default(0);;
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_transfers');
    }
}
