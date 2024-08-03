<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_papers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_subject_info_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            // $table->foreignId('ques_info_id')->constrained()->cascadeOnDelete();
            // $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            // $table->string('set', 64);
            // $table->tinyInteger('set_no');
            $table->enum('type', ['multiple_choice', 'short_question', 'long_question']);
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
        Schema::dropIfExists('question_papers');
    }
};
