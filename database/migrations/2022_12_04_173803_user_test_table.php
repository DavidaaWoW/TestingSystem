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
        Schema::create('user_test', function (Blueprint $table){
            $table->string('id')->nullable(false)->primary();
            $table->string('user');
            $table->string('test');
            $table->string('status');
            $table->timestamp('end_time');
            $table->foreign('user')->references('id')->on('users');
            $table->foreign('test')->references('id')->on('tests');
            $table->foreign('status')->references('id')->on('test_statuses');
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
        Schema::dropIfExists('user_test');
    }
};
