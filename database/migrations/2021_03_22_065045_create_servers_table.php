<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->integer('server_id')->unsigned()->nullable()->unique();
            $table->string('identifier')->nullable()->unique();
            $table->integer('client_id')->unsigned();
            $table->integer('plan_id')->unsigned();
            $table->string('billing_cycle');
            $table->timestamp('next_due');
            $table->string('payment_method');
            $table->string('addon')->nullable();
            $table->string('subdomain_name')->nullable();
            $table->string('subdomain')->nullable();
            $table->integer('subdomain_port')->unsigned()->nullable();
            $table->string('subdomain_provider')->nullable();
            $table->tinyInteger('status')->unsigned()->default(1);
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
        Schema::dropIfExists('servers');
    }
}
