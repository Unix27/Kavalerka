<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->bigInteger('quantity')->default(1);
            $table->string('title')->nullable();
            $table->double('price')->default(0);
            $table->timestamps();

            $table->unsignedBigInteger('variation_id')->nullable();

            $table->foreign('order_id')
                ->references('id')->on('shop_orders')->cascadeOnDelete();

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
        Schema::dropIfExists('shop_order_items');
    }
}
