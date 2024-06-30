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
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('id_physical_person');
            $table->integer('id_store');
            $table->integer('id_pavement');
            $table->integer('id_equipment');
            $table->string('title');
            $table->longText('description');
            $table->string('contact');
            $table->date('dt_opening');
            $table->date('dt_process');
            $table->date('dt_service');
            $table->integer('id_status');
            $table->string('ds_status');
            $table->integer('id_physcal_person_executor');
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
        Schema::dropIfExists('service_orders');
    }
};
