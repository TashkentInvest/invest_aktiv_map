<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKengashXulosasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kengash_xulosasi', function (Blueprint $table) {
            $table->id();
            $table->string('ariza_raqami')->nullable();
            $table->string('bayon_raqami');
            $table->date('bayon_sanasi');
            $table->text('bayon_izoh')->nullable();
            $table->string('xulosa_raqami');
            $table->date('xulosa_sanasi');
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
        Schema::dropIfExists('kengash_xulosasi');
    }
}
