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
        Schema::create('exam_group_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_group_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->enum('status', ['active', 'failed', 'passed'])->default('active');
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_group_members');
    }
};
