<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCustomerAddressesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('customer_addresses', function (Blueprint $table) {
			$table->string('street')->nullable();
			$table->string('build')->nullable();
			$table->string('apartment')->nullable();
			$table->string('nova_poshta')->nullable();
			$table->string('justin')->nullable();
			$table->string('ukr_poshta')->nullable();

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
