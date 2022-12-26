<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id');
            $table->foreignId('facility_id');
            $table->foreignId('room_id');
            $table->date('date_required');
            $table->integer('qty');
            $table->integer('price');
            $table->integer('postage_price')->nullable();
            $table->integer('total_price');
            $table->string('necessity');
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
        Schema::dropIfExists('detail_submissions');
    }
}
