<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index('client_name_indx');;
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('secondary_email')->nullable();
            $table->string('client_website')->nullable();
            $table->string('client_url');
            $table->string('contact_person_name');
            $table->string('contact_person_phone');
            $table->string('contact_person_secondary_phone')->nullable();
            $table->string('contact_person_email');
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('clients');
    }
}
