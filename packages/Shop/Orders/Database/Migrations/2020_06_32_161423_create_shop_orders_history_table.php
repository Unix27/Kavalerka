<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopOrdersHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_orders_history', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('text')->nullable();

            $table->foreign('order_id')
                ->references('id')->on('shop_orders')->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')->on('customers');

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
        Schema::dropIfExists('shop_orders_history');
    }
}
