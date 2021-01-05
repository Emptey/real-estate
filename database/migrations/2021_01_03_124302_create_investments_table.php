<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_listing_id');
            $table->foreign('property_listing_id')->references('id')->on('property_listings')->cascade('delete');
            $table->unsignedBigInteger('avail_slot');
            $table->decimal('amount_per_slot', 8, 2);
            $table->date('first_rent_payment_date')->nullable();
            $table->date('next_rent_payment_date')->nullable();
            $table->date('last_rent_payment_date')->nullable();
            $table->date('sell_off_payment_date');
            $table->date('expiry_date');
            $table->boolean('is_rented', 1)->default(0);
            $table->boolean('is_filled', 1)->default(0);
            $table->boolean('is_complete', 1)->default(0);
            $table->boolean('is_active', 1)->default(1);
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
        Schema::dropIfExists('investments');
    }
}
