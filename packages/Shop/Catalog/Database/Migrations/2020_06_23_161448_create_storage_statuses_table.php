<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorageStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_storage_statuses', function (Blueprint $table) {
            $table->id();

            $table->timestamps();
        });


        Schema::create('shop_storage_statuses_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale');
            $table->unsignedBigInteger('storage_status_id');
            $table->string('name');


            $table->timestamps();

            $table->foreign('storage_status_id')->references('id')
                ->on('shop_storage_statuses')->cascadeOnDelete();
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
