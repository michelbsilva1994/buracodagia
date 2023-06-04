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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->char('type_person',2);
            $table->string('cpf')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('name_contractor');
            $table->date('dt_contraction');
            $table->date('dt_renovation')->nullable();
            $table->date('dt_finalization')->nullable();
            $table->date('dt_cancellation')->nullable();
            $table->date('dt_signature')->nullable();

            $table->bigInteger('id_physical_person')->unsigned()->nullable();
            $table->foreign('id_physical_person')->references('id')->on('physical_people');

            $table->bigInteger('id_legal_person')->unsigned()->nullable();
            $table->foreign('id_legal_person')->references('id')->on('legal_people');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
