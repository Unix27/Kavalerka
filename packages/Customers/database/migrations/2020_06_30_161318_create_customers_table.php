<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('customer_deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('postcode')->nullable();
            $table->integer('payment_id')->nullable();
            $table->boolean('default')->default(true);
            $table->boolean('billing')->default(false);

        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->unsignedBigInteger('role_id')->nullable()->default(5);


            $table->string('email')->unique();
            $table->string('username')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('additional_phone')->nullable();
            $table->string('gender')->nullable();
            $table->timestamp('date_of_birth')->nullable();
            $table->boolean('active')->default(1);
            $table->string('locale')->nullable();
            $table->string('default_payment_method')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->boolean('is_subscribed_to_news_letter')->default(0);
            $table->text('notes')->nullable();
            $table->text('session_id')->nullable();
            $table->boolean('is_block')->nullable()->default(false);

            $table->timestamp('last_activity')->nullable();

            $table->timestamps();

            $table->foreign('group_id')
                ->references('id')->on('customers')->onDelete('set null');


            $table->foreign('delivery_id')
                ->references('id')->on('customers')->onDelete('set null');


            $table->foreign('role_id')
                ->references('id')->on('admin_roles')->onDelete('set null');
        });

        Schema::create('customer_password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_password_resets');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('customer_deliveries');

    }
}
