<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopPromotionsBrandsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_promotions_brands', function (Blueprint $table) {
			$table->bigIncrements('id');

			$table->unsignedBigInteger('promotion_id')->unsigned();
			$table->unsignedBigInteger('brand_id')->unsigned();

			$table->timestamps();

			$table->foreign('promotion_id')->references('id')->on('shop_promotions')->onDelete('cascade');
			$table->foreign('brand_id')->references('id')->on('shop_brands')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('shop_promotions_brands');
	}
}
