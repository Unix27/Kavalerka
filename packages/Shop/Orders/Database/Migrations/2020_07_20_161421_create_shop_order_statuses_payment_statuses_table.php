<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopOrderStatusesPaymentStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_order_statuses_payment_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_status_id')->nullable();
            $table->unsignedBigInteger('payment_status_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();

            $table->foreign('order_status_id')
                ->references('id')->on('shop_order_statuses')->onDelete('cascade');

            $table->foreign('payment_status_id')
                ->references('id')->on('shop_order_payments_status')->onDelete('cascade');

            $table->foreign('order_id')
                ->references('id')->on('shop_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_order_payments_status');
    }
}
