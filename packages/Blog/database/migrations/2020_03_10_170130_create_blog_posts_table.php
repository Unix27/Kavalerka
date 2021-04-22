<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('active')->default(1);
            $table->string('image')->nullable();
            $table->integer('likes')->default(0);
            $table->integer('views')->default(0);
            $table->string('tags')->nullable();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->timestamp('published_at')->nullable();
            $table->bigInteger('published_by')->unsigned()->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('published_by')->references('id')->on('admins');
            $table->foreign('category_id')->references('id')->on('blog_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_posts');
    }
}
