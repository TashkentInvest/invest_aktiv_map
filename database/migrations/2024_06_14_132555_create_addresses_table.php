<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('addresses', function (Blueprint $table) {
                $table->id();
                // $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
                
                
                $table->unsignedBigInteger('client_id')->nullable();
                $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
                $table->string('yuridik_address')->nullable();
                $table->string('home_address')->nullable();
                $table->string('company_location')->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
