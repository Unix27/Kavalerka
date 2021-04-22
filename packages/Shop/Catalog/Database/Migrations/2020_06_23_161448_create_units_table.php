<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_units', function (Blueprint $table) {
            $table->id();

            $table->decimal('value');
            $table->boolean('default')->default(0);

            $table->timestamps();
        });

        Schema::create('shop_units_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale');
            $table->unsignedBigInteger('unit_id');
            $table->string('title');
            $table->string('unit');

            $table->timestamps();

            $table->foreign('unit_id')->references('id')
                ->on('shop_units')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_statuses');
    }
}
