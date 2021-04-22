<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToShopCategoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('shop_categories', function (Blueprint $table) {
			$table->string('slug');
			$table->boolean('show_on_front')->default(false);
			$table->unsignedBigInteger('main_category_id')->nullable();

			$table->foreign('main_category_id')
				->references('id')->on('shop_categories')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	}
}
