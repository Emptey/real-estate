<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellOffPayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_off_payouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('investment_id');
            $table->foreign('user_id')->references('id')->on('users')->cascade('delete');
            $table->foreign('investment_id')->references('id')->on('investments')->cascade('delete');
            $table->string('receipt')->nullable();
            $table->decimal('amount_paid', 8, 2);
            $table->boolean('is_paid')->default(0);
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
        Schema::dropIfExists('sell_off_payouts');
    }
}
