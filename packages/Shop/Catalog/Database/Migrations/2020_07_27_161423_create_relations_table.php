<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_relations', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->timestamps();


            $table->bigInteger('current_product_id')->unsigned()->nullable();
            $table->foreign('current_product_id')
                ->references('id')->on('shop_products')->onDelete('set null');

            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->foreign('product_id')
                ->references('id')->on('shop_products')->onDelete('set null');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_videos');
    }
}
