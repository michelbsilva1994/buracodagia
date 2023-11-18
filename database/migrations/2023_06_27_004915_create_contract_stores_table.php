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
        Schema::create('contract_stores', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('id_store')->unsigned();
            $table->foreign('id_store')->references('id')->on('stores');

            $table->bigInteger('id_contract')->unsigned();
            $table->foreign('id_contract')->references('id')->on('contracts');

            $table->float('store_price');
            $table->string('create_user')->nullable();
            $table->string('update_user')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_stores');
    }
};
