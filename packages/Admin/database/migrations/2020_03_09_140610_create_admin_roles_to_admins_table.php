<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRolesToAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('admin_roles_to_admins', function (Blueprint $table) {
//            $table->bigInteger('role_id')->unsigned();
//            $table->bigInteger('admin_id')->unsigned();
//            $table->timestamps();
//
//            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
//            $table->foreign('role_id')->references('id')->on('admin_roles')->onDelete('cascade');
//            $table->primary(['role_id', 'admin_id']);
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('admin_roles_to_admins');
    }
}
