<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopReviewsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_reviews', function (Blueprint $table) {
			$table->id();

			$table->unsignedBigInteger('customer_id')->nullable();
			$table->integer('parent_id')->default(0)->nullable();
			$table->integer('rating')->nullable();
			$table->string('name');
			$table->string('email')->nullable();
			$table->text('comment');
			$table->boolean('is_verified')->default(0);
			$table->boolean('show_on_front')->default(0);

			$table->foreign('customer_id')
				->references('id')->on('customers')->cascadeOnDelete();

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
		Schema::dropIfExists('shop_product_reviews');
	}
}
