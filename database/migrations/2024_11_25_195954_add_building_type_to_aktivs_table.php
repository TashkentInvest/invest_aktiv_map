<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuildingTypeToAktivsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aktivs', function (Blueprint $table) {
            $table->enum('building_type', ['yer', 'TurarBino', 'NoturarBino'])->nullable();
        });
    }
    //if building_type yer
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aktivs', function (Blueprint $table) {
            $table->dropColumn('building_type');

        });
    }
}
