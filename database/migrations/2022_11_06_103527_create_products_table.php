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
    public function up()
    {
        //'name', 'in_stock', 'sold', 'total_profit', 'rate'
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('in_stock')->default(0);
            $table->integer('sold')->default(0);
            $table->integer('total_profit')->default(0);
            $table->decimal('rate', 2, 1)->default(0.0);
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->integer('unit_price')->default(0);
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
        Schema::dropIfExists('products');
    }
};
