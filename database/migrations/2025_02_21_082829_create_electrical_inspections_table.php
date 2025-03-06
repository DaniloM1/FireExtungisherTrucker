<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectricalInspectionsTable extends Migration
{
    /**
     * Pokretanje migracije.
     */
    public function up()
    {
        Schema::create('electrical_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->date('inspection_date');
            $table->date('next_inspection_date');
            $table->text('description')->nullable();
            $table->decimal('cost', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Vraćanje migracije.
     */
    public function down()
    {
        Schema::dropIfExists('electrical_inspections');
    }
}
