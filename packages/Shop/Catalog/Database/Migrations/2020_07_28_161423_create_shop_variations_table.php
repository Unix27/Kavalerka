<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_variations', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->bigInteger('attribute_id')->unsigned()->nullable();

            $table->string('sku')->nullable();
            $table->decimal('price')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('locale')->nullable();

            $table->boolean('active')->nullable()->default(1);
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('slug')->nullable()->default(1);
            $table->integer('sort')->default(100);
            $table->string('image')->nullable();


            $table->boolean('out_of_stock')->default(false);
            $table->integer('min_order')->default(1);
            $table->boolean('subtract_storage')->default(true);
            $table->string('out_of_stock_action')->nullable();
            $table->boolean('need_delivery')->default(false);
            $table->timestamp('receipt_date')->nullable();
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('tax_id')->nullable();
            $table->string('upc')->nullable();
            $table->string('ean')->nullable();
            $table->string('jan')->nullable();
            $table->string('isbn')->nullable();
            $table->string('mpn')->nullable();


            $table->foreign('product_id')
                ->references('id')->on('shop_products')->onDelete('cascade');
            $table->foreign('attribute_id')
                ->references('id')->on('shop_attribute_values')->onDelete('cascade');
        });


        Schema::create('shop_variation_values', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->bigInteger('variation_id')->unsigned()->nullable();
            $table->bigInteger('value_id')->unsigned()->nullable();

            $table->foreign('product_id')
                ->references('id')->on('shop_products')->onDelete('cascade');
            $table->foreign('variation_id')
                ->references('id')->on('shop_variations')->onDelete('cascade');
            $table->foreign('value_id')
                ->references('id')->on('shop_attribute_values')->onDelete('cascade');
        });

        Schema::create('shop_variation_images', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->unsignedBigInteger('variation_id');
            $table->integer('sort')->default(0);
            $table->timestamps();

            $table->foreign('variation_id')
                ->references('id')->on('shop_variations')->cascadeOnDelete();
        });



        Schema::create('shop_variations_shop_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('variation_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreign('variation_id')->references('id')->on('shop_variations')
                ->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('shop_categories')
                ->cascadeOnDelete();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_videos');
    }
}
