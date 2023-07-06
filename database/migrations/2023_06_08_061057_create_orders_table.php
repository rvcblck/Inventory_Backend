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
            $table->uuid('order_id')->primary();
            $table->integer('order_number');
            $table->string('qr_code');
            $table->foreignUuid('company_id')
                ->references('company_id')
                ->on('company')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignUuid('request_id')
                ->references('request_id')
                ->on('request')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignUuid('supplier_id')->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('delivery_location')->nullable();
            $table->string('transaction_type')->nullable(); // Deliver, Pick up, Either Pick Up Or Deliver
            $table->dateTime('date_needed')->nullable();
            $table->float('order_total_price')->nullable();
            $table->boolean('is_bidding')->default(false);
            $table->dateTime('bidding_start')->nullable();
            $table->dateTime('bidding_end')->nullable();
            $table->boolean('archived')->default(false);
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
