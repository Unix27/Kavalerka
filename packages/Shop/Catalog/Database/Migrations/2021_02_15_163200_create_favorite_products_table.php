<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoriteProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('favorite_products', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('customer_id')->unsigned();
			$table->bigInteger('product_id')->unsigned();
			$table->timestamps();

			$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
			$table->foreign('product_id')->references('id')->on('shop_products')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('favorite_products');
	}
}
