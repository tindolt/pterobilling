<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('user_id')->unsigned()->nullable()->unique();
            $table->string('api_key')->nullable();
            $table->string('password');
            $table->integer('referer_id')->unsigned()->nullable();
            $table->decimal('credit')->unsigned()->default(0.00);
            $table->integer('clicks')->unsigned()->default(0);
            $table->integer('sign_ups')->unsigned()->default(0);
            $table->integer('purchases')->unsigned()->default(0);
            $table->decimal('commissions')->unsigned()->default(0.00);
            $table->string('currency')->default('USD');
            $table->string('country')->default('0');
            $table->string('timezone')->default('UTC');
            $table->string('language')->default('EN');
            $table->boolean('is_admin')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('clients');
    }
}
