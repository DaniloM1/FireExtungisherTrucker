<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceEventLocationsTable extends Migration
{
    /**
     * Pokretanje migracije.
     */
    public function up()
    {
        Schema::create('service_event_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_event_id')
                ->constrained('service_events')
                ->onDelete('cascade');
            $table->foreignId('location_id')
                ->constrained('locations')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Vraćanje migracije.
     */
    public function down()
    {
        Schema::dropIfExists('service_event_locations');
    }
}
