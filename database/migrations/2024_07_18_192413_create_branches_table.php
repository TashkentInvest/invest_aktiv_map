<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('action', ['created', 'updated', 'deleted'])->nullable();
            $table->timestamp('action_timestamp')->nullable();
            $table->softDeletes();

            $table->foreignId('client_id')->constrained('clients');

            $table->unsignedBigInteger('loyiha_hajmi_malumotnoma_id')->nullable();
            $table->foreign('loyiha_hajmi_malumotnoma_id')->references('id')->on('loyiha_hajmi_malumotnoma')->onDelete('cascade');


            $table->unsignedBigInteger('loyiha_hujjatlari_id')->nullable();
            $table->foreign('loyiha_hujjatlari_id')->references('id')->on('loyiha_hujjatlari')->onDelete('cascade');


            $table->unsignedBigInteger('ruxsatnoma_id')->nullable();
            $table->foreign('ruxsatnoma_id')->references('id')->on('ruxsatnomalar')->onDelete('cascade');

            $table->unsignedBigInteger('sub_street_id')->nullable();
            $table->foreign('sub_street_id')->references('id')->on('sub_streets')->onDelete('cascade');

            $table->foreignId('kt_id')->nullable()->constrained('kts')->unique();
            $table->foreignId('kj_id')->nullable()->constrained('kjs')->unique();
            $table->foreignId('ko_id')->nullable()->constrained('kos')->unique();
            $table->foreignId('kz_id')->nullable()->constrained('kzs')->unique();
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
        Schema::dropIfExists('branches');
    }
}
