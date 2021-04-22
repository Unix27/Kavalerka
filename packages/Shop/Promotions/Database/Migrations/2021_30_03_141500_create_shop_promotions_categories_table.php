<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopPromotionsCategoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_promotions_categories', function (Blueprint $table) {
			$table->bigIncrements('id');

			$table->unsignedBigInteger('promotion_id')->unsigned();
			$table->unsignedBigInteger('category_id')->unsigned();

			$table->timestamps();

			$table->foreign('promotion_id')->references('id')->on('shop_promotions')->onDelete('cascade');
			$table->foreign('category_id')->references('id')->on('shop_categories')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('shop_promotions_categories');
	}
}
