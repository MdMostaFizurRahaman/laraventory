<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->string('account_name');
            $table->string('account_number')->nullable();
            $table->string('account_mobile_number')->nullable();
            $table->tinyInteger('account_type')->nullable();
            $table->double('opening_balance')->default(0);
            $table->double('balance')->default(0);
            $table->string('branch_name')->index('account_branch_name_indx')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('bank')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('status');
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->bigInteger('deleted_by')->unsigned()->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
