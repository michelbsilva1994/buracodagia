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
        Schema::create('legal_people', function (Blueprint $table) {
            $table->id();
            $table->string('corporate_name');
            $table->string('fantasy_name')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone');
            $table->string('cnpj')->unique();
            $table->string('cep')->nullable();
            $table->string('public_place')->nullable();
            $table->integer('nr_public_place')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
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
        Schema::dropIfExists('legal_people');
    }
};
