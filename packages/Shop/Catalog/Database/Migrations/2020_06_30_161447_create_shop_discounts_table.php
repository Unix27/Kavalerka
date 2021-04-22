<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('group_id')->nullable();

            $table->integer('quantity')->nullable();
            $table->boolean('is_percent')->nullable();
            $table->decimal('price')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();

            $table->timestamps();
            $table->foreign('product_id')
                ->references('id')->on('shop_products')->cascadeOnDelete();
            $table->foreign('group_id')
                ->references('id')->on('customer_groups')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_discounts');
    }
}
