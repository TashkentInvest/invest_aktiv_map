<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoyihaHujjatlariTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyiha_hujjatlari', function (Blueprint $table) {
            $table->id();
            $table->text('kompleks')->nullable();
            $table->text('loyiha_hajmi_haqida_malumotnoma_shablon')->nullable();
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
        Schema::dropIfExists('loyiha_hujjatlari');
    }
}
