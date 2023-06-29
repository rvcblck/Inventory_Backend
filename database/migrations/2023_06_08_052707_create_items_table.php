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
            $table->string('item_name');
            $table->string('item_description');
            $table->float('item_price');
            $table->integer('item_quantity');
            $table->string('item_image')->nullable();
            $table->foreignUuid('category_id')
            ->references('category_id')
            ->on('categories')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignUuid('supplier_id')
            ->nullable()
            ->references('id')
            ->on('users')
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
