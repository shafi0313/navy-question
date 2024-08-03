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
        Schema::create('question_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('time')->nullable();
            $table->tinyInteger('d_hour')->nullable();
            $table->tinyInteger('d_minute')->nullable();
            $table->string('mode', 191)->nullable();
            $table->string('trade', 191)->nullable();
            $table->enum('status', ['Pending', 'Created', 'Started', 'Completed'])->nullable();
            $table->string('note', 255)->nullable();
            $table->string('option_note', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_infos');
    }
};
