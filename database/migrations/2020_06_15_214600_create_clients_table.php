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
            $table->id('client_id');
            $table->string('first_name', 40);
            $table->string('middle_name', 30)->nullable();
            $table->string('last_name', 30);
            $table->string('name_suffix', 4)->nullable();
            $table->string('phone_no', 40);
            $table->string('address');
            $table->string('sex', 1);
            $table->unsignedTinyInteger('age');
            $table->date('date_of_birth');
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
        Schema::dropIfExists('clients');
    }
}
