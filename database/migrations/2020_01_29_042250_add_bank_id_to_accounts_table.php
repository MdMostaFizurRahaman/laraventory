<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankIdToAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('bank');
            $table->dropColumn('account_type');
            $table->bigInteger('bank_id')->unsigned()->after('branch_code')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('bank')->nullable();
            $table->tinyInteger('account_type')->nullable();
            $table->dropForeign('accounts_bank_id_foreign');
            $table->dropColumn('bank_id');
        });
    }
}
