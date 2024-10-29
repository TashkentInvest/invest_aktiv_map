<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAktivsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktivs', function (Blueprint $table) {
            $table->id();
            $table->string('address'); // Manzil
            $table->string('object_name'); // Объект номи
            $table->string('balance_keeper'); // Балансда сақловчи
            $table->string('location'); // Мўлжал
            $table->decimal('land_area', 8, 2); // Ер майдони
            $table->decimal('building_area', 8, 2); // Бино майдони
            $table->boolean('gas'); // Газ (мавжуд/мавжуд эмас)
            $table->boolean('water'); // Сув (мавжуд/мавжуд эмас)
            $table->boolean('electricity'); // Электр (мавжуд/мавжуд эмас)
            $table->text('additional_info')->nullable(); // Қўшимча маълумот
            $table->string('location_info')->nullable(); // Локация
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
        Schema::dropIfExists('aktivs');
    }
}
