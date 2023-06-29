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
        Schema::create('items_return', function (Blueprint $table) {
            $table->uuid('item_return_id')->primary();
            $table->foreignUuid('order_list_id')
            ->references('order_list_id')
            ->on('order_list')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignUuid('from')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignUuid('to')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->integer('item_return_quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_return');
    }
};
