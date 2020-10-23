<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id('beneficiary_id');
            $table->foreignId('barangay_id')->nullable();
            $table->string('outside_laoag_address')->nullable();
            $table->string('name', 100);
            $table->string('phone_no', 40);
            $table->string('sex', 1);
            $table->date('date_of_birth');
            $table->timestamps();

            $table->foreign('barangay_id')
                                    ->references('barangay_id')
                                    ->on('barangays')
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
        Schema::dropIfExists('beneficiaries');
    }
}
