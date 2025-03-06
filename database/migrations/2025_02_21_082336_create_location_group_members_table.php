<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationGroupMembersTable extends Migration
{
    /**
     * Pokretanje migracije.
     */
    public function up()
    {
        Schema::create('location_group_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_group_id')
                ->constrained('location_groups')
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
        Schema::dropIfExists('location_group_members');
    }
}
