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
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->nullable()->constrained('groups')->nullOnDelete(); // Opcionalno, uređaj može biti u grupi
            $table->string('serial_number');
            $table->string('model');
            $table->string('manufacturer');
            $table->date('manufacture_date')->nullable();
            $table->date('next_service_date')->nullable(); // Planirani datum sljedećeg servisa
            $table->string('position')->nullable(); // Opcionalno: pozicija aparata unutar lokacije (npr. soba, sprat)
            $table->date('hvp')->nullable(); // Dodato: preciznija lokacija, npr. soba ili sprat
            $table->enum('status', ['active', 'inactive', 'needs_service'])->default('active');
            $table->timestamps();
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
