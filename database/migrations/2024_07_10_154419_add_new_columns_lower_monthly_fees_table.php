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
        Schema::table('lower_monthly_fees', function (Blueprint $table) {
            $table->char('operation_type', 1);
            $table->integer('id_lower_monthly_fees_reverse')->nullable();
            $table->integer('id_lower_monthly_fees_origin')->nullable();
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lower_monthly_fees', function (Blueprint $table) {
            //
        });
    }
};
