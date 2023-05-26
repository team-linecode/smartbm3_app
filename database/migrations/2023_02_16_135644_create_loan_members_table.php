<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_members', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('classroom_id')->nullable();
            $table->foreignId('expertise_id')->nullable();
            $table->string('qrcode')->nullable();
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
        Schema::dropIfExists('loan_members');
    }
}
