<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasdiqlanganLoyixaHujjatlariTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasdiqlangan_loyixa_hujjatlari', function (Blueprint $table) {
            $table->id();
            $table->string('bosh_reja');
            $table->string('qavatlar_rejasi');
            $table->string('boshqa_turdagi_hujjatlar');
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
        Schema::dropIfExists('tasdiqlangan_loyixa_hujjatlari');
    }
}
