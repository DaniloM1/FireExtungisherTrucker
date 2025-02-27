<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationGroupsTable extends Migration
{
    /**
     * Pokretanje migracije.
     */
    public function up()
    {
        Schema::create('location_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Naziv grupe, npr. "Aman Istok", "Majdanpek Zona"
            $table->text('description')->nullable(); // Opcioni opis grupe
            $table->timestamps();
        });
    }

    /**
     * Vraćanje migracije.
     */
    public function down()
    {
        Schema::dropIfExists('location_groups');
    }
}
