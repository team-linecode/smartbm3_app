<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->nullable();
            $table->foreignId('loan_member_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('teacher_id')->nullable();
            $table->foreignId('room_id')->nullable();
            $table->string('description')->nullable();
            $table->dateTime('loan_date');
            $table->dateTime('estimation_return_date');
            $table->dateTime('return_date')->nullable();
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
        Schema::dropIfExists('loans');
    }
}
