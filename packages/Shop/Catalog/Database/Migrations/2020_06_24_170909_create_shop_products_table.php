<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('shop_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('image')->nullable();
            $table->double('price')->default(0.00);
            $table->boolean('active')->default(true);
            $table->integer('sort')->default(100);
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('model')->nullable();
            $table->boolean('out_of_stock')->default(false);
            $table->integer('min_order')->default(1);
            $table->boolean('subtract_storage')->default(true);

            $table->unsignedBigInteger('out_of_stock_action')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('unit_weight_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable()->default(1);

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

            $table->boolean('is_sale')->default(0);
            $table->boolean('is_miniland')->default(1);
            $table->integer('popularity')->default(0);

            $table->timestamps();

            $table->foreign('brand_id')
                ->references('id')->on('shop_brands')->onDelete('set null');


            $table->foreign('out_of_stock_action')
                ->references('id')->on('shop_storage_statuses')->onDelete('set null');

            $table->foreign('unit_id')
                ->references('id')->on('shop_units')->onDelete('set null');

            $table->foreign('unit_weight_id')
                ->references('id')->on('shop_unit_weights')->onDelete('set null');

            $table->foreign('status_id')
                ->references('id')->on('shop_statuses')->onDelete('set null');

        });

        Schema::create('shop_product_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('locale');
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('slug');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('shop_products')
                ->cascadeOnDelete();
        });


        Schema::create('shop_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('show_menu')->default(true);
            $table->boolean('show_catalog')->default(true);
            $table->integer('sort_menu')->default(100);
            $table->integer('sort_catalog')->default(100);
            $table->string('image')->nullable();

            $table->bigInteger('status_id')->unsigned()->nullable();
            $table->foreign('status_id')
                ->references('id')->on('statuses')->onDelete('set null');

            $table->timestamps();
        });

        Schema::table('shop_categories', function (Blueprint $table) {

            $table->foreign('parent_id')
                ->references('id')->on('shop_categories')->onDelete('set null');
        });

        Schema::create('shop_category_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('locale');
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('slug');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->longText('seo_text')->nullable();
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')->on('shop_categories')->cascadeOnDelete();
        });

        Schema::create('shop_products_shop_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('shop_products')
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
        Schema::dropIfExists('shop_category_translations');
        Schema::dropIfExists('shop_products_shop_categories');
        Schema::dropIfExists('shop_categories');
        Schema::dropIfExists('shop_product_translations');
        Schema::dropIfExists('shop_products');
    }
}
