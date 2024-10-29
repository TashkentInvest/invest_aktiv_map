<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuxsatnomalarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruxsatnomalar', function (Blueprint $table) {
            $table->id();
    
            $table->unsignedBigInteger('sub_street_id')->nullable();
            $table->foreign('sub_street_id')->references('id')->on('sub_streets')->onDelete('cascade');

            $table->unsignedBigInteger('ruxsatnoma_turi_id')->nullable();
            $table->foreign('ruxsatnoma_turi_id')->references('id')->on('ruxsatnoma_turi')->onDelete('cascade');

            $table->unsignedBigInteger('ruxsatnoma_berilgan_ish_turi_id')->nullable();
            $table->foreign('ruxsatnoma_berilgan_ish_turi_id')->references('id')->on('ruxsatnoma_berilgan_ish_turi')->onDelete('cascade');

            $table->unsignedBigInteger('ruxsatnoma_kim_tamonidan_id')->nullable();
            $table->foreign('ruxsatnoma_kim_tamonidan_id')->references('id')->on('ruxsatnoma_kim_tamonidan')->onDelete('cascade');
            
            $table->date('ruxsat_etuvchi_hujjat_sanasi');
            $table->string('ruxsat_etuvchi_hujjat_raqami');
            $table->string('kadastr_raqami');

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
        Schema::dropIfExists('ruxsatnomalar');
    }
}
