<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShartnomaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shartnoma', function (Blueprint $table) {
            $table->id();
            $table->string('shartnoma_raqami')->nullable();
            $table->date('shartnoma_sanasi')->nullable();
            
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            
            $table->integer('status')->default(0);

            $table->unsignedBigInteger('art_ma_lumotlari_id')->nullable();
            $table->unsignedBigInteger('kengash_xulosasi_id')->nullable();
            $table->unsignedBigInteger('ekspertiza_xulosasi_id')->nullable();
            $table->unsignedBigInteger('dakn_gasn_inspection_id')->nullable();

            $table->foreign('art_ma_lumotlari_id')->references('id')->on('art_ma_lumotlari');
            $table->foreign('kengash_xulosasi_id')->references('id')->on('kengash_xulosasi');
            $table->foreign('ekspertiza_xulosasi_id')->references('id')->on('ekspertiza_xulosasi');
            $table->foreign('dakn_gasn_inspection_id')->references('id')->on('dakn_gasn_inspection');


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
        Schema::dropIfExists('shartnoma');
    }
}
