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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('Admin')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->string('name',100);
            $table->string('code',60);
            $table->dateTime('date_time');
            $table->tinyInteger('total_ques');
            $table->string('time',10);
            // $table->tinyInteger('mark_per_right_ans');
            // $table->tinyInteger('mark_per_wrong_ans');
            $table->enum('status',['Pending', 'Started', 'Completed']);
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
        Schema::dropIfExists('exams');
    }
};
