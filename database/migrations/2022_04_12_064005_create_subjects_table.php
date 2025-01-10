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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rank_id')->constraint('ranks')->cascadeOnDelete();
            $table->string('name', 255);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable()->constraint('users')->nullOnDelete();
            $table->unsignedBigInteger('updated_by')->nullable()->constraint('users')->nullOnDelete();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
};
