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
            $table->string('contact')->nullable();
            $table->date('dt_opening');
            $table->date('dt_process')->nullable();
            $table->date('dt_service')->nullable();
            $table->char('id_status',1);
            $table->integer('id_physcal_person_executor')->nullable();
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
