<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopPromotionsCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_promotions_category_translations', function (Blueprint $table) {
					$table->bigIncrements('id');
					$table->string('locale');
					$table->bigInteger('category_id')->unsigned();
					$table->string('title');
					$table->string('heading')->nullable();
					$table->string('meta_title')->nullable();
					$table->string('meta_description')->nullable();
					$table->string('meta_keywords')->nullable();
					$table->timestamps();

					$table->foreign('category_id')->references('id')->on('shop_promotions_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_promotions_category_translations');
    }
}
