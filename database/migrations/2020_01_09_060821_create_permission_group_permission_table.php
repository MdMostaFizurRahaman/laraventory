<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionGroupPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_group_permission', function (Blueprint $table) {

            $table->bigInteger('permission_group_id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->foreign('permission_group_id')
                ->references('id')->on('permission_groups')
                ->onDelete('cascade');
            $table->foreign('permission_id')
                ->references('id')->on('permissions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_group_permission');
    }
}
