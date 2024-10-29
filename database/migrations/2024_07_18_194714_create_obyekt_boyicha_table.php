<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObyektBoyichaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obyekt_boyicha', function (Blueprint $table) {
            $table->id();
            $table->string('ruhsatnoma_uchun_ariza');
            $table->string('ruhsatnoma');
            $table->string('art_uchun_ariza');
            $table->string('art');
            $table->string('kengash_xulosasi');
            $table->string('ekspertiza_xulosasi');
            $table->string('loyiha_hujjatlari');
            $table->string('dakn_gasn_qurilishi_uchun_ariza');
            $table->string('dakn_gasn_ko_chirma');
            $table->string('tolov_habarnomalari');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obyekt_boyicha');
    }
}
