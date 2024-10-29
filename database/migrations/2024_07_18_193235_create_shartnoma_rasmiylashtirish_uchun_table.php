<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShartnomaRasmiylashtirishUchunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('shartnoma_rasmiylashtirish_uchun', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id')->nullable();
        $table->foreign('user_id')->references('id')->on('users');

        $table->unsignedBigInteger('shartnoma_id')->nullable();
        $table->unsignedBigInteger('sugurta_polisi_id')->nullable();
        $table->unsignedBigInteger('bank_kafolati_id')->nullable();
        $table->unsignedBigInteger('tolov_grafigi_id')->nullable();

        $table->foreign('shartnoma_id')->references('id')->on('shartnoma');
        $table->foreign('sugurta_polisi_id')->references('id')->on('sugurta_polisi');
        $table->foreign('bank_kafolati_id')->references('id')->on('bank_kafolati');
        $table->foreign('tolov_grafigi_id')->references('id')->on('tolov_grafigi');
        $table->integer('status')->default(0);

        $table->text('comment')->nullable();

        $table->unsignedBigInteger('order_atkaz_id')->nullable();
        $table->foreign('order_atkaz_id')->references('id')->on('order_atkaz')->onDelete('cascade');

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
        Schema::dropIfExists('shartnoma_rasmiylashtirish_uchun');
    }
}
