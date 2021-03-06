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
            $table->bigInteger('from')->unsigned();
            $table->bigInteger('to')->unsigned();
            $table->text('details');
            $table->float('amount');
            $table->string('currency')->default('eur');
            $table->timestamps();

            $table->foreign('from')
                ->references('id')
                ->on('accounts');

            $table->foreign('to')
                ->references('id')
                ->on('accounts');
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
