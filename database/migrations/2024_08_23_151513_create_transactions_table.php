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
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('transaction_code', 12)->primary();
            $table->date('transaction_date');
            $table->string('customer_name');
            $table->decimal('total_amount', 10, 0);
            $table->string('status')->default('Pending');
            $table->foreignId('payment_id')->constrained('payments')->cascadeOnUpdate()->cascadeOnDelete(); // Jenis pembayaran
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete(); // Pengguna yang melakukan input data
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
        Schema::dropIfExists('transactions');
    }
};
