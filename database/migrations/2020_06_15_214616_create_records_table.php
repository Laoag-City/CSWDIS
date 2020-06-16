<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id('record_id');
            $table->foreignId('client_id');
            $table->foreignId('service_id')->nullable();
            $table->date('date_requested');
            $table->string('problem_presented');
            $table->string('initial_assessment')->nullable();
            $table->string('recommendation')->nullable();
            $table->string('action_taken')->nullable();
            $table->date('action_taken_date')->nullable();
            $table->timestamps();

            $table->foreign('client_id')
                                    ->references('client_id')
                                    ->on('clients')
                                    ->onUpdate('cascade')
                                    ->onDelete('cascade');

            $table->foreign('service_id')
                                    ->references('service_id')
                                    ->on('services')
                                    ->onUpdate('cascade')
                                    ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
}
