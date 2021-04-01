<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('resource');
            $table->integer('amount')->unsigned();
            $table->decimal('price')->unsigned();
            $table->string('plans')->nullable();
            $table->string('categories')->nullable();
            $table->decimal('setup_fee')->unsigned()->default(0);
            $table->integer('trial')->unsigned()->default(0);
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
        Schema::dropIfExists('addons');
    }
}
