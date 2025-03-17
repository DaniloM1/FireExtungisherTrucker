<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceEventsTable extends Migration
{
    /**
     * Pokretanje migracije.
     */
    public function up()
    {
        Schema::create('service_events', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['pp_device', 'hydrant']);
            $table->date('service_date');
            $table->date('next_service_date');
            $table->string('evid_number');
            // Pošto korisničku vezu ne koristimo eksplicitno (preko Eloquent odnosa), ostavljamo user_id kao unsignedBigInteger
            $table->unsignedBigInteger('user_id');
            $table->text('description')->nullable();
            $table->decimal('cost', 10, 2)->default(0);
            $table->string('status')->default('active');
            $table->timestamps();

            // Ako koristiš user model, možeš kasnije dodati i foreign key:
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Vraćanje migracije.
     */
    public function down()
    {
        Schema::dropIfExists('service_events');
    }
}
