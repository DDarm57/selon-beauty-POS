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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code', 100);
            $table->integer('user_id');
            $table->string('customer_name', 100)->nullable();
            $table->integer('total_qty');
            $table->bigInteger('total_price');
            $table->bigInteger('total_price_after_discount');
            $table->bigInteger('pay');
            $table->bigInteger('change');
            $table->enum('payments', ['cash', 'online']);
            $table->enum('transaction_tipe', ['retail', 'agent']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
