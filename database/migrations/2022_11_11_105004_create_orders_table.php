<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //'id', "name_of_owner", "email_of_owner","user_id","number_of_products","number_of_items","total_price", "status", "order_date"
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name_of_owner');
            $table->string('email_of_owner');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('number_of_products');
            $table->integer('number_of_items');
            $table->integer('total_price');
            $table->integer('status');
            $table->date('order_date')->default(now());
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
        Schema::dropIfExists('orders');
    }
};
