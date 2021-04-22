<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeNullableAttributeGroupIdTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{


		Schema::table('shop_attributes', function (Blueprint $table) {
			$table->dropForeign(['attribute_group_id']);
			$table->unsignedBigInteger('attribute_group_id')->nullable()->change();

			$table->foreign('attribute_group_id')->references('id')
				->on('shop_attribute_groups')->cascadeOnDelete();
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('shop_attributes');
	}
}
