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
        Schema::create('order_list', function (Blueprint $table) {
            $table->uuid('order_list_id')->primary();
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
            $table->string('status'); // pending , incomplete, complete
            $table->float('order_quantity')->nullable();
            $table->float('order_completed')->nullable();
            $table->float('price_per_item')->nullable();
            $table->boolean('archived')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item');
    }
};
