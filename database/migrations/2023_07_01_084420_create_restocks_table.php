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
        Schema::create('restocks', function (Blueprint $table) {
            $table->uuid('restock_id')->primary();
            $table->foreignUuid('company_id')->nullable()
                ->references('company_id')
                ->on('company')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignUuid('order_id')
                ->references('order_id')
                ->on('orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignUuid('item_id')
                ->references('item_id')
                ->on('items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->float('current_item_quantity')->nullable();
            $table->float('added_item_quantity')->nullable();
            $table->float('total_item')->nullable();
            $table->dateTime('date_added')->nullable();
            $table->boolean('archived')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restock');
    }
};
