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
        Schema::create('service_order_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('id_type_history')->nullable();
            $table->string('ds_type_history')->nullable();
            $table->longText('history');
            $table->date('dt_creation');
            $table->date('dt_release');
            $table->integer('id_physical_person');
            $table->string('create_user');
            $table->string('update_user');

            $table->bigInteger('id_service_order')->unsigned();
            $table->foreign('id_service_order')->references('id')->on('service_orders');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_histories');
    }
};
