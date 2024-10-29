<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtMaLumotlariTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('art_ma_lumotlari', function (Blueprint $table) {
            $table->id();
            $table->string('ariza_raqami');
            $table->date('ariza_sanasi');
            $table->string('art_raqami');
            $table->date('art_sanasi');
            $table->text('xulosa_izoh')->nullable();

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
        Schema::dropIfExists('art_ma_lumotlari');
    }
}
