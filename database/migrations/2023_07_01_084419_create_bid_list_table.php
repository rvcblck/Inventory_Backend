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
        Schema::create('bid_list', function (Blueprint $table) {
            $table->uuid('bid_list_id')->primary();
            $table->foreignUuid('bid_id')
                ->references('bid_id')
                ->on('bid')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignUuid('order_list_id')
                ->references('order_list_id')
                ->on('order_list')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->float('price_per_item');
            $table->float('total_price');
            $table->boolean('archived')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bid_list');
    }
};
