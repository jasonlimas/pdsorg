<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->text('div');
            $table->text('sales_person');
            $table->integer('number')->unsigned();
            $table->text('quote_date');
            $table->foreignId('sender_id');
            $table->foreignId('client_id');
            $table->json('items');
            $table->integer('tax')->unsigned();
            $table->json('terms_conditions');
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
        Schema::dropIfExists('quotes');
    }
}
