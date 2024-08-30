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
        Schema::create('transaction_products', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code_product', 12);
            $table->foreign('transaction_code_product')->references('transaction_code')->on('transactions')->cascadeOnUpdate()->cascadeOnDelete(); // Mengambil data transaksi
            $table->foreignId('product_id')->constrained('products')->cascadeOnUpdate()->cascadeOnDelete(); // Mengambil data dari produk
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 0);
            $table->decimal('total_price', 10, 0);
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
        Schema::dropIfExists('transaction_products');
    }
};
