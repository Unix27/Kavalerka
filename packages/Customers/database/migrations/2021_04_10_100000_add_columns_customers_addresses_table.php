<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsCustomersAddressesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('customer_addresses', function (Blueprint $table) {

			$table->text('np_city_code')->nullable();
			$table->text('up_city_code')->nullable();
			$table->text('ji_city_code')->nullable();

			$table->text('np_warehouse_code')->nullable();
			$table->text('up_warehouse_code')->nullable();
			$table->text('ji_warehouse_code')->nullable();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('customer_addresses');

	}
}
