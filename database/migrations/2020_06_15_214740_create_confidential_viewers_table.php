<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfidentialViewersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confidential_viewers', function (Blueprint $table) {
            $table->id('confidential_viewer_id');
            $table->foreignId('record_id');
            $table->foreignId('user_id');
            $table->timestamps();

            $table->foreign('record_id')
                                    ->references('record_id')
                                    ->on('records')
                                    ->onUpdate('cascade')
                                    ->onDelete('cascade');

            $table->foreign('user_id')
                                    ->references('user_id')
                                    ->on('users')
                                    ->onUpdate('cascade')
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
        Schema::dropIfExists('confidential_viewers');
    }
}
