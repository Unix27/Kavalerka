<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitWeightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_unit_weights', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('value');
            $table->boolean('default')->default(0);

            $table->timestamps();
        });

        Schema::create('shop_unit_weights_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale');
            $table->unsignedBigInteger('unit_weight_id');
            $table->string('title');
            $table->string('unit');

            $table->timestamps();

            $table->foreign('unit_weight_id')->references('id')
                ->on('shop_unit_weights')->cascadeOnDelete();
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
