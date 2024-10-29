<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoyihaHajmiMalumotnomaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyiha_hajmi_malumotnoma', function (Blueprint $table) {
            $table->id();
            $table->decimal('binoning_qurilish_hajmi', 15, 2)->nullable();
            $table->decimal('ruxsatdan_tashqari_yuqori_hajm', 15, 2)->nullable();
            $table->decimal('binoning_avtoturargoh_qismi_hajmi', 15, 2)->nullable();
            $table->decimal('binoning_texnik_qavatlar_xonalar_hajmi', 15, 2)->nullable();
            $table->decimal('turar_joy_binosining_umumiy_foydalanishdagi_qismi_hajmi', 15, 2)->nullable();
            $table->decimal('branch_kubmetr', 15, 2)->nullable();
            $table->text('qoshimcha_malumot')->nullable();
            $table->string('obyekt_nomi')->nullable();
            $table->string('geolokatsiya')->nullable();
            $table->decimal('latitude', 10, 7)->nullable(); // Add latitude column
            $table->decimal('longitude', 10, 7)->nullable(); // Add longitude column
            $table->string('zone_name')->nullable(); // Add longitude column
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
        Schema::dropIfExists('loyiha_hajmi_malumotnoma');
    }
}
