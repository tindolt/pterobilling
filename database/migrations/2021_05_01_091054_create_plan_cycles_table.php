<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanCyclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_cycles', function (Blueprint $table) {
            $table->id();
            $table->integer('plan_id')->unsigned();
            $table->integer('cycle_length')->unsigned();
            $table->tinyInteger('cycle_type')->unsigned();
            $table->decimal('init_price')->unsigned();
            $table->decimal('renew_price')->unsigned();
            $table->decimal('setup_fee')->unsigned()->default(0.00);
            $table->decimal('late_fee')->unsigned()->default(0.00);
            $table->integer('trial_length')->unsigned()->nullable();
            $table->tinyInteger('trial_type')->unsigned()->nullable();
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
        Schema::dropIfExists('plan_cycles');
    }
}
