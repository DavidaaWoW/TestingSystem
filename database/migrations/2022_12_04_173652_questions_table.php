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
        Schema::create('questions', function (Blueprint $table){
            $table->string('id')->nullable(false)->primary();
            $table->string('name');
            $table->string('test');
            $table->string('question_variation');
            $table->double('score');
            $table->integer('order_number');
            $table->foreign('test')->references('id')->on('tests');
            $table->foreign('question_variation')->references('id')->on('question_variations');
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
        Schema::dropIfExists('questions');
    }
};
