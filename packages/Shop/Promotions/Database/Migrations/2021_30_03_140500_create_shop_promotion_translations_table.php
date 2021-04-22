<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopPromotionTranslationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_promotion_translations', function (Blueprint $table) {

			$table->id();

			$table->string('title')->nullable();
			$table->text('description')->nullable();
			$table->string('locale');
			$table->unsignedBigInteger('promotion_id')->nullable();

			$table->foreign('promotion_id')
				->references('id')->on('shop_promotions')->onDelete('cascade');

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
		Schema::dropIfExists('shop_promotion_translations');
	}
}
