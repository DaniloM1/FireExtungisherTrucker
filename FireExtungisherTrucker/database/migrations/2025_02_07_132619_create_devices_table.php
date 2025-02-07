<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Pokretanje migracije.
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('group_id')->nullable(); // Opcionalno, uređaj može biti u grupi
            $table->string('serial_number');
            $table->string('model');
            $table->string('manufacturer');
            $table->date('manufacture_date')->nullable();
            $table->date('next_service_date')->nullable(); // Planirani datum sljedećeg servisa
            $table->string('position')->nullable(); // Opcionalno: pozicija aparata unutar lokacije (npr. soba, sprat)
            $table->enum('status', ['active', 'inactive', 'needs_service'])->default('active');
            $table->timestamps();

            // Definicija stranih ključeva
            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('cascade');

            // Ako se grupa obriše, postavljamo group_id na NULL
            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('set null');
        });
    }

    /**
     * Vraćanje migracije.
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
