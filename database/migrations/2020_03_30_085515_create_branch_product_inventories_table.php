<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchProductInventoriesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('branch_product_inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->default(0);
            $table->bigInteger('branch_id')->default(0);
            $table->bigInteger('product_id')->default(0);
            $table->double('sale_price')->default(0);
            $table->double('quantity')->default(0);
            $table->double('alert_quantity')->default(0);
            $table->string('vat')->default(0);
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
    public function down() {
        Schema::dropIfExists('branch_product_inventories');
    }
}
