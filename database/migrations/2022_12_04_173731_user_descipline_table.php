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
        Schema::create('user_discipline', function (Blueprint $table){
            $table->string('id')->nullable(false)->primary();
            $table->string('user');
            $table->string('discipline');
            $table->foreign('user')->references('id')->on('users');
            $table->foreign('discipline')->references('id')->on('disciplines');
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
        Schema::dropIfExists('user_discipline');
    }
};
