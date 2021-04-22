<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopPromotionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_promotions', function (Blueprint $table) {

			$table->id();

			$table->string('type')->default('retail');
			$table->string('image');
			$table->date('date_start');
			$table->date('date_end');
			$table->unsignedBigInteger('main_category');
			$table->bigInteger('category_id')->unsigned();
			$table->boolean('active')->default(false);

			$table->double('discount')->default(0.00);
			$table->boolean('is_percent')->default(true);

			$table->string('upc')->nullable();
			$table->string('ean')->nullable();
			$table->string('jan')->nullable();
			$table->string('isbn')->nullable();
			$table->string('mpn')->nullable();


			$table->foreign('main_category')->references('id')->on('shop_categories')->onDelete('cascade');
			$table->foreign('category_id')->references('id')->on('shop_promotions_category')->onDelete('cascade');

			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('shop_promotions');
	}
}
