<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopPromocodesCategoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_promocodes_categories', function (Blueprint $table) {
			$table->bigIncrements('id');

			$table->unsignedBigInteger('promocode_id')->unsigned();
			$table->unsignedBigInteger('category_id')->unsigned();

			$table->timestamps();

			$table->foreign('promocode_id')->references('id')->on('shop_promocodes')->onDelete('cascade');
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
		Schema::dropIfExists('shop_promocodes_categories');
	}
}
