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
        Schema::create('monthly_payments', function (Blueprint $table) {
            $table->id();
            $table->date('dt_cancellation')->nullable();
            $table->date('due_date');
            $table->date('dt_payday')->nullable();
            $table->float('fine_value')->nullable()->default(0.0);
            $table->float('interest_amount')->nullable()->default(0.0);
            $table->float('discount_value')->nullable()->default(0.0);
            $table->float('total_payable');
            $table->float('amount_paid')->default(0.0);
            $table->float('balance_value');
            $table->char('id_monthly_status',2)->nullable();
            $table->string('monthly_status')->nullable();
            $table->char('id_type_cancellation',2)->nullable();
            $table->string('type_cancellation')->nullable();
            $table->string('download_user')->nullable();
            $table->string('cancellation_user')->nullable();

            $table->bigInteger('id_contract')->unsigned();
            $table->foreign('id_contract')->references('id')->on('contracts');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_payments');
    }
};
