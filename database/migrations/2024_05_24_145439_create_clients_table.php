<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('action', ['created', 'updated', 'deleted'])->nullable();
            $table->timestamp('action_timestamp')->nullable();
            $table->softDeletes();

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('sub_street_id')->nullable();
            $table->foreign('sub_street_id')->references('id')->on('sub_streets')->onDelete('cascade');
            $table->unsignedBigInteger('xujjat_turi_id')->nullable();
            $table->foreign('xujjat_turi_id')->references('id')->on('xujjat_turi')->onDelete('cascade');
            $table->unsignedBigInteger('xujjat_berilgan_joyi_id')->nullable();
            $table->foreign('xujjat_berilgan_joyi_id')->references('id')->on('xujjat_berilgan_joyi')->onDelete('cascade');

            $table->enum('mijoz_turi', ['yuridik', 'fizik'])->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('contact');
            $table->string('contact2')->nullable();
            $table->date('birth_date')->nullable();
            $table->integer('created_by_client')->default(0);
            $table->integer('confirmed_for_client')->default(0);
            $table->boolean('is_qonuniy')->default(true);
            $table->string('stir')->nullable()->unique();

            $table->string('email')->nullable();
            $table->boolean('is_deleted')->default(0);
            $table->integer('status')->default(0);
            $table->text('client_description')->nullable();
            $table->string('unique_code')->nullable();

            $table->string('home_number')->nullable();
            $table->string('apartment_number')->nullable();
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
        Schema::dropIfExists('Clients');
    }
}
