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
        Schema::create('item_quantity', function (Blueprint $table) {
            $table->uuid('item_quantity_id')->primary();
            $table->foreignUuid('company_id')->nullable()
                ->references('company_id')
                ->on('company')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignUuid('item_id')->nullable()
                ->references('item_id')
                ->on('items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->float('item_quantity')->nullable();
            $table->boolean('archived')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_quantity');
    }
};
