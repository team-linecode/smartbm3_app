<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->string('invoice_no');
            $table->integer('total')->default(0);
            $table->enum('status', ['unpaid', 'pending', 'paid', 'refund', 'cancel'])->default('pending');
            $table->dateTimeTz('date');
            $table->string('note')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('payment_method_id')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
