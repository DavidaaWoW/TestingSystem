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
        Schema::create('users', function (Blueprint $table){
            $table->string('id')->nullable(false)->primary();
            $table->string('name')->nullable();
            $table->string('email')->nullable(false)->unique('email');
            $table->string('password')->nullable(false);
            $table->rememberToken();
            $table->string('code')->nullable()->unique('code');
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
        Schema::dropIfExists('users');
    }
};
