<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalesCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locales_currency', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('locale_id')->nullable();
            $table->unsignedBigInteger('settings_currency_id')->nullable();

            $table->foreign('locale_id')
                ->references('id')->on('locales')->onDelete('set null');

            $table->foreign('settings_currency_id')
                ->references('id')->on('settings_currency')->onDelete('set null');

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
        Schema::dropIfExists('locales_currency');
    }
}
