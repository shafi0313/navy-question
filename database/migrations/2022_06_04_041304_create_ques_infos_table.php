<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ques_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            // $table->tinyInteger('set');
            $table->date('date');
            $table->time('time')->nullable();
            $table->tinyInteger('d_hour')->default(0);
            $table->tinyInteger('d_minute')->default(0);
            $table->string('mode', 191);
            $table->string('trade', 191)->nullable();
            $table->enum('status', ['Pending', 'Created', 'Started', 'Completed'])->nullable();
            $table->string('note', 255)->nullable();
            $table->string('option_note', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ques_infos');
    }
};
