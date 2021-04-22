<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopPromocodesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_promocodes', function (Blueprint $table) {

			$table->id();

			$table->boolean('active')->default(false);
			$table->string('type')->default('retail');
			$table->string('promocode');
			$table->integer('quantity')->default(0);
			$table->date('date_start');
			$table->date('date_end');
			$table->string('min_price')->nullable();

			$table->double('discount')->default(0);
			$table->boolean('is_percent')->default(false);

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
		Schema::dropIfExists('shop_promocodes');
	}
}
