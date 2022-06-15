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
            $table->tinyInteger('set');
            $table->dateTime('date_time');
            $table->tinyInteger('total_mark');
            $table->tinyInteger('pass_mark');
            $table->tinyInteger('d_hour')->default(0);
            $table->tinyInteger('d_minute')->default(0);
            $table->string('mode',80);
            $table->string('trade',80)->nullable();
            $table->enum('status',['Pending', 'Created', 'Started', 'Completed'])->nullable();
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
