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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->unsignedBigInteger('id_meja');
            $table->foreign('id_meja')->references('id')
                ->on('tables')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            //makanan yang dipesan
            $table->unsignedBigInteger('id_food');
            $table->foreign('id_food')->references('id')
                ->on('food')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->integer('total_harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
