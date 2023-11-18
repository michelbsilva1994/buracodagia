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
        Schema::create('physical_people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('birth_date')->nullable();
            $table->string('email')->nullable();
            $table->string('cpf')->unique();
            $table->string('rg')->unique()->nullable();
            $table->string('telephone');
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
        Schema::dropIfExists('physical_people');
    }
};
