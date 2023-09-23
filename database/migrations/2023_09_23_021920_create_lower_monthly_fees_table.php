<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lower_monthly_fees', function (Blueprint $table) {
            $table->id();
            $table->float('amount_paid');
            $table->char('id_type_payment',2)->nullable();
            $table->string('type_payment')->nullable();
            $table->char('id_chargeback_low',2)->nullable();
            $table->string('chargeback_low')->nullable();
            $table->date('dt_payday')->nullable();
            $table->date('dt_chargeback')->nullable();
            $table->string('download_user')->nullable();
            $table->string('chargeback_user')->nullable();

            $table->bigInteger('id_monthly_payment')->unsigned();
            $table->foreign('id_monthly_payment')->references('id')->on('monthly_payments');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lower_monthly_fees');
    }
};
