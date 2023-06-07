<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_line', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orders')->nullable();
            $table->foreign('orders')->references('id')
                ->on('orders')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->unsignedBigInteger('tables')->nullable();
            $table->foreign('tables')->references('id')
                ->on('tables')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->unsignedBigInteger('foods')->nullable();
            $table->foreign('foods')->references('id')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->integer('harga');
            $table->integer('qyt');
            $table->integer('subtotal');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_line');
    }
};
