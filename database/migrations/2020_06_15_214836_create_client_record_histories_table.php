<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientRecordHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_record_histories', function (Blueprint $table) {
            $table->id('client_record_history_id');
            $table->foreignId('client_id')->nullable();
            $table->foreignId('record_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('action', 50);
            $table->timestamps();

            $table->foreign('client_id')
                                    ->references('client_id')
                                    ->on('clients')
                                    ->onUpdate('cascade')
                                    ->onDelete('cascade');

            $table->foreign('record_id')
                                    ->references('record_id')
                                    ->on('records')
                                    ->onUpdate('cascade')
                                    ->onDelete('cascade');

            $table->foreign('user_id')
                                    ->references('user_id')
                                    ->on('users')
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
        Schema::dropIfExists('client_record_histories');
    }
}
