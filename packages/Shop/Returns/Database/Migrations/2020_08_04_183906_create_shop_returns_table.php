<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_returns', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('reason_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('variation_id')->nullable();


            $table->string('customer_email')->nullable();
            $table->string('customer_first_name')->nullable();
            $table->string('customer_last_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_notes')->nullable();
            $table->integer('quantity')->nullable();
            $table->boolean('packet');
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')->on('shop_orders')->onDelete('set null');

            $table->foreign('status_id')
                ->references('id')->on('shop_return_statuses')->onDelete('set null');

            $table->foreign('reason_id')
                ->references('id')->on('shop_return_reasons')->onDelete('set null');

            $table->foreign('product_id')
                ->references('id')->on('shop_products')->onDelete('set null');

            $table->foreign('variation_id')
                ->references('id')->on('shop_variations')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_returns');
    }
}
