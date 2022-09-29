<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nip', 15)->nullable();
            $table->string('nisn', 15)->nullable();
            $table->string('username', 15)->unique();
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->string('no_encrypt');
            $table->string('image');
            $table->foreignId('group_id');
            $table->foreignId('schoolyear_id');
            $table->enum('alumni', [0, 1]);
            $table->foreignId('last_education_id')->nullable();
            $table->foreignId('role_id');
            $table->foreignId('classroom_id');
            $table->foreignId('expertise_id');
            $table->string('verify_token');
            $table->rememberToken();
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
}
