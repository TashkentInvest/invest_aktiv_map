<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSugurtaPolisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sugurta_polisi', function (Blueprint $table) {
            $table->id();
            $table->string('sugurta_kompaniya_nomi');
            $table->string('stir');
            $table->string('hujjat_nomi');
            $table->string('hujjat_raqami');
            $table->date('hujjat_sanasi');
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
        Schema::dropIfExists('sugurta_polisi');
    }
}
