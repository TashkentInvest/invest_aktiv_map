<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTolovGrafigiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tolov_grafigi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shartnoma_id')->nullable();

            $table->foreign('shartnoma_id')->references('id')->on('shartnoma');
            $table->string('payment_type')->nullable();
            $table->decimal('percentage_input', 15, 2)->nullable();
            $table->decimal('installment_quarterly', 15, 2)->nullable();
            $table->decimal('calculated_quarterly_payment', 15, 2)->nullable();
            $table->decimal('first_payment_percent', 15, 2);
            $table->decimal('minimum_wage', 15, 2);
            $table->decimal('generate_price', 15, 2);
            $table->date('payment_deadline')->nullable();
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
        Schema::dropIfExists('tolov_grafigi');
    }
}
