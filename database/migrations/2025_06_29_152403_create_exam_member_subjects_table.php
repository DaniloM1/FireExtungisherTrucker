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
        Schema::create('exam_member_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_group_member_id')->constrained();
            $table->foreignId('exam_subject_id')->constrained();
            $table->enum('status', ['locked', 'unlocked', 'passed', 'failed'])->default('locked');
            $table->timestamp('unlocked_at')->nullable();
            $table->timestamp('result_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_member_subjects');
    }
};
