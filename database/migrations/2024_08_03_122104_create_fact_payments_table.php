<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fact_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_schedule_id')->constrained('payment_schedules')->onDelete('cascade');
            $table->decimal('payment_amount', 15, 2);
            $table->date('payment_date');
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('fact_payments');
    }
}
