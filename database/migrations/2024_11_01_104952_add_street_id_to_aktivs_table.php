<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStreetIdToAktivsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aktivs', function (Blueprint $table) {
            $table->unsignedBigInteger('street_id')->nullable(); // Add the street_id column
            $table->foreign('street_id')->references('id')->on('streets')->onDelete('cascade'); // Add foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aktivs', function (Blueprint $table) {
            $table->dropForeign(['street_id']); // Drop the foreign key constraint
            $table->dropColumn('street_id');    // Drop the street_id column
        });
    }
}
