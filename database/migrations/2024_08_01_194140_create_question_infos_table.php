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
            $table->foreignId('rank_id')->constrained()->cascadeOnDelete();
            $table->string('exam_name', 255);
            $table->date('date');
            $table->time('time')->nullable();
            $table->string('d_hour', 8)->nullable();
            $table->string('d_minute', 8)->nullable();
            $table->unsignedTinyInteger('status')->nullable();
            $table->text('note')->nullable();
            $table->text('comment')->nullable();
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
