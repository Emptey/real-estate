<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_listings', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('description');
            $table->string('address', 200);
            $table->unsignedBigInteger('bedroom')->nullable;
            $table->unsignedBigInteger('bathroom');
            $table->unsignedBigInteger('toilet');
            $table->unsignedBigInteger('slot');
            $table->unsignedBigInteger('duration');
            $table->decimal('purchase_amount', 8, 2);
            $table->decimal('mngt_fee', 8, 2);
            $table->decimal('sell_off_price', 8, 2);
            $table->unsignedBigInteger('sell_off_profit_percent');
            $table->decimal('rentage_price', 8, 2)->nullable();
            $table->unsignedBigInteger('rentage_profit_percent')->nullable();
            $table->boolean('is_rentable', 1);
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
        Schema::dropIfExists('property_listings');
    }
}
