<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_attribute_groups', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(0);
            $table->integer('sort')->default(100);
            $table->string('code');
            $table->timestamps();
        });

        Schema::create('shop_attribute_group_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale');
            $table->unsignedBigInteger('attribute_group_id');
            $table->string('title');
            $table->timestamps();

            $table->foreign('attribute_group_id')->references('id')
                ->on('shop_attribute_groups')->cascadeOnDelete();
        });

        Schema::create('shop_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_group_id');
            $table->boolean('active')->default(0);
            $table->boolean('use_filter')->default(0);
            $table->boolean('use_color')->default(0);
            $table->boolean('required')->default(0);
            $table->integer('sort')->default(100);
            $table->timestamps();



            $table->foreign('attribute_group_id')->references('id')
                ->on('shop_attribute_groups')->cascadeOnDelete();
        });

        Schema::create('shop_attribute_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale');
            $table->unsignedBigInteger('attribute_id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('attribute_id')->references('id')
                ->on('shop_attributes')->cascadeOnDelete();
        });

        Schema::create('shop_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('locale');
            $table->string('color')->nullable();
            $table->longText('value');
            $table->timestamps();

            $table->foreign('attribute_id')->references('id')
                ->on('shop_attributes')->cascadeOnDelete();

            $table->foreign('product_id')->references('id')
                ->on('shop_products')->cascadeOnDelete();
        });

        Schema::create('shop_attribute_values_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale');
            $table->unsignedBigInteger('attribute_value_id');
            $table->string('title');


            $table->timestamps();

            $table->foreign('attribute_value_id')->references('id')
                ->on('shop_attribute_values')->cascadeOnDelete();
        });



//        Schema::create('shop_attribute_options', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('attribute_id');
//            $table->timestamps();
//
//            $table->foreign('attribute_id')
//                ->references('id')->on('shop_attributes')->cascadeOnDelete();
//        });
//
//        Schema::create('shop_attribute_option_translations', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('attribute_option_id');
//            $table->string('locale');
//            $table->text('title');
//            $table->timestamps();
//
//            $table->foreign('attribute_option_id')
//                ->references('id')->on('shop_attribute_options')->cascadeOnDelete();
//        });

        Schema::create('shop_products_shop_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('attribute_id');
            $table->string('locale');
            $table->timestamps();

            $table->foreign('attribute_id')->references('id')
                ->on('shop_attribute_values')->cascadeOnDelete();
            $table->foreign('product_id')->references('id')
                ->on('shop_products')->cascadeOnDelete();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('shop_attribute_option_translations');
//        Schema::dropIfExists('shop_attribute_options');
        Schema::dropIfExists('shop_products_shop_attributes');
        Schema::dropIfExists('shop_attribute_values');
        Schema::dropIfExists('shop_attribute_translations');
        Schema::dropIfExists('shop_attributes');
        Schema::dropIfExists('shop_attribute_groups');
    }
}
