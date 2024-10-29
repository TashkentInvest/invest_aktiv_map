<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubyektShaklisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subyekt_shaklis', function (Blueprint $table) {
            $table->id();            
            $table->string('name')->nullable();
            $table->string('name_ru')->nullable();
            $table->string('description')->nullable();
            $table->string('description_ru')->nullable();
            $table->string('code')->nullable();
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
        Schema::dropIfExists('subyekt_shaklis');
    }
}
