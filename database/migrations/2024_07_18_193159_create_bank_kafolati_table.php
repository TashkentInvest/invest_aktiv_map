<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankKafolatiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_kafolati', function (Blueprint $table) {
            $table->id();
            $table->string('bank_nomi');
            $table->string('stir');
            $table->string('hujjat_raqami');
            $table->date('hujjat_sanasi');
            $table->string('hujjat_nomi');
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
        Schema::dropIfExists('bank_kafolati');
    }
}
