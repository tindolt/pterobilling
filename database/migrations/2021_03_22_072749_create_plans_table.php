<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('category_id')->unsigned();
            $table->integer('cpu')->unsigned();
            $table->integer('ram')->unsigned();
            $table->integer('swap');
            $table->integer('disk')->unsigned();
            $table->integer('io')->unsigned();
            $table->integer('databases')->unsigned();
            $table->integer('backups')->unsigned();
            $table->integer('allocations')->unsigned();
            $table->decimal('price')->unsigned();
            $table->string('cycles');
            $table->decimal('setup_fee')->unsigned()->default(0.00);
            $table->integer('trial')->unsigned()->default(0);
            $table->integer('discount')->unsigned()->nullable();
            $table->string('coupons')->nullable();
            $table->integer('addon_limit')->unsigned()->default(0);
            $table->integer('global_limit')->unsigned()->default(0);
            $table->integer('per_client_limit')->unsigned()->default(0);
            $table->integer('order')->unsigned()->default(0);
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
        Schema::dropIfExists('plans');
    }
}
