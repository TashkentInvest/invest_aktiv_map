<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEkspertizaXulosasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ekspertiza_xulosasi', function (Blueprint $table) {
            $table->id();
            $table->string('tashkilot_nomi');
            $table->string('ekspertiza_xulosa_raqami');
            $table->date('ekspertiza_xulosa_sanasi');
            $table->string('shaffofdan_at_raqami');
            $table->date('shaffofdan_at_sanasi');
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
        Schema::dropIfExists('ekspertiza_xulosasi');
    }
}
