<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaknGasnInspectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dakn_gasn_inspection', function (Blueprint $table) {
            $table->id();
            $table->string('ariza_raqami');
            $table->date('ariza_sanasi');
            $table->string('ko_chirma_gasn_raqami');
            $table->date('ko_chirma_gasn_sanasi');
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
        Schema::dropIfExists('dakn_gasn_inspection');
    }
}
