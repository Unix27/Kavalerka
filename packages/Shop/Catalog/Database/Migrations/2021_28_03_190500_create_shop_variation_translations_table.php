<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopVariationTranslationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_variation_translations', function (Blueprint $table) {
			$table->bigIncrements('id');

			$table->string('locale')->nullable();
			$table->string('title')->nullable();
			$table->bigInteger('variations_id')->unsigned();

			$table->foreign('variations_id')->references('id')->on('shop_variations')->onDelete('cascade');

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
		Schema::dropIfExists('shop_variation_translations');
	}
}
