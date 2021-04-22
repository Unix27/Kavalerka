<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_brands', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(true);
            $table->string('image')->nullable();
            $table->integer('sort')->default(100);
            $table->timestamps();
        });

        Schema::create('shop_brand_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->string('locale');
            $table->string('title');
            $table->longText('description')->nullable();
            $table->timestamps();


            $table->foreign('brand_id')
                ->references('id')->on('shop_brands')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_brand_translations');
        Schema::dropIfExists('shop_brands');
    }
}
