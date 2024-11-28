<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilesToAktivsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aktivs', function (Blueprint $table) {
            $table->string('kadastr_pdf')->nullable(); // For Kadastr file
            $table->string('hokim_qarori_pdf')->nullable(); // For Hokim qarori file
            $table->string('transfer_basis_pdf')->nullable(); // For transfer basis file
        });
    }
    
    public function down()
    {
        Schema::table('aktivs', function (Blueprint $table) {
            $table->dropColumn(['kadastr_pdf', 'hokim_qarori_pdf', 'transfer_basis_pdf']);
        });
    }
}
