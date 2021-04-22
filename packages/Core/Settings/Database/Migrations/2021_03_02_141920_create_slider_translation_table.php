<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSliderTranslationTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('slider_translations', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('slider_id')->unsigned();
			$table->string('locale');
			$table->string('name');
			$table->string('title');
			$table->string('desc');
			$table->string('button_name');
			$table->string('link');
			$table->string('image');
			$table->timestamps();

			$table->foreign('slider_id')->references('id')->on('sliders')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('slider_translations');
	}
}
