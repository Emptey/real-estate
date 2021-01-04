<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_investments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('investment_id');
            $table->foreign('user_id')->references('id')->on('users')->cascade('delete');
            $table->foreign('investment_id')->references('id')->on('investments')->cascade('delete');
            $table->string('receipt_id');
            $table->unsignedBigInteger('purchased_slot');
            $table->decimal('amount', 8, 2);
            $table->boolean('is_paid', 1);
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
        Schema::dropIfExists('user_investments');
    }
}
