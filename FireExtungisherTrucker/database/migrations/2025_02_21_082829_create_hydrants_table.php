<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHydrantsTable extends Migration
{
    /**
     * Pokretanje migracije.
     */
    public function up()
    {
        Schema::create('hydrants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->string('serial_number');
            $table->string('type');
            $table->string('model');
            $table->string('manufacturer');
            $table->date('manufacture_date')->nullable();
            $table->date('next_service_date')->nullable();
            $table->string('position')->nullable();
            $table->date('hvp')->nullable(); // Opcionalno: preciznija lokacija (npr. soba ili sprat)
            $table->float('static_pressure');
            $table->float('dynamic_pressure');
            $table->float('flow'); // Protok
            $table->enum('status', ['active', 'inactive', 'needs_service'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Vraćanje migracije.
     */
    public function down()
    {
        Schema::dropIfExists('hydrants');
    }
}
