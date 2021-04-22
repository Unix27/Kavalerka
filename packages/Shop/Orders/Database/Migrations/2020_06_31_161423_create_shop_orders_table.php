<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_orders', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();

            $table->string('customer_email')->nullable();
            $table->string('customer_first_name')->nullable();
            $table->string('customer_last_name')->nullable();

            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('delivery_id')->nullable();

            $table->integer('total_item_count')->default(0);
            $table->integer('total_qty_ordered')->default(0);

            $table->string('shipping_method')->nullable();
            $table->string('shipping_country')->nullable();
            $table->string('shipping_region')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_postcode')->nullable();
            $table->string('shipping_address')->nullable();

            $table->string('coupon_code')->nullable();

            $table->string('currency_code')->nullable();

            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->string('payment_status')->nullable();
            $table->float('shipping_price')->default(0);
            $table->float('total_price')->default(0);

            $table->string('admin_notes')->nullable();
            $table->string('customer_notes')->nullable();


            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')->on('customers')->onDelete('set null');

            $table->foreign('status_id')
                ->references('id')->on('shop_order_statuses')->onDelete('set null');

            $table->foreign('payment_method_id')
                ->references('id')->on('shop_order_payments_methods')->onDelete('set null');

            $table->foreign('group_id')
                ->references('id')->on('customers')->onDelete('set null');

            $table->foreign('delivery_id')
                ->references('id')->on('shop_order_deliveries')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_orders');
    }
}
