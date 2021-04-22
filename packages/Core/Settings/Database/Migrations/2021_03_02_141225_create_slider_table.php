<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSliderTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sliders', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('post_type');
			$table->integer('active')->default(1);
			$table->bigInteger('category_id')->unsigned()->nullable();
			$table->bigInteger('page_id')->unsigned()->nullable();
			$table->timestamps();

			$table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
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
		Schema::dropIfExists('sliders');
	}
}
