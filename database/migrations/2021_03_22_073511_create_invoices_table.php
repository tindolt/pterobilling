<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->unsigned();
            $table->decimal('total_due')->unsigned();
            $table->string('products_id');
            $table->string('prices');
            $table->decimal('subtotal')->unsigned();
            $table->integer('tax_id')->unsigned()->nullable();
            $table->decimal('credit')->unsigned()->default(0.00);
            $table->string('payment_method');
            $table->timestamp('due_date');
            $table->boolean('paid')->unsigned()->default(false);
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
        Schema::dropIfExists('invoices');
    }
}
