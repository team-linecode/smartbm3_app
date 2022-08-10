<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_details', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->foreignId('cost_id')->nullable();
            $table->foreignId('classroom_id')->nullable();
            $table->foreignId('group_id')->nullable();
            $table->foreignId('semester_id')->nullable();
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
        Schema::dropIfExists('cost_details');
    }
}
