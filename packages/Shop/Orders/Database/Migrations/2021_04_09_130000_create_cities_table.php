<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cities', function (Blueprint $table) {
			$table->id();
			$table->timestamps();
			$table->string('ref');
			$table->boolean('active')->default(0);
			$table->decimal('price')->nullable();
			$table->string('area_ref');
		});

		Schema::create('cities_translations', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('city_id')->unsigned()->nullable();
			$table->string('locale');
			$table->string('title');

			$table->foreign('city_id')
				->references('id')->on('cities')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('shop_order_statuses');
	}
}
