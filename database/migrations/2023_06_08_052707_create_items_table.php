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
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('item_id')->primary();
            $table->string('item_name')->nullable();
            $table->string('item_description')->nullable();
            $table->foreignUuid('unit_id')->nullable()
                ->references('unit_id')
                ->on('units')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('item_image')->nullable();
            $table->foreignUuid('category_id')->nullable()
                ->references('category_id')
                ->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item');
    }
};
