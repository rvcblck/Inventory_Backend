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
        Schema::create('received_by', function (Blueprint $table) {
            $table->uuid('receive_by_id')->primary();
            $table->foreignUuid('order_id')
            ->references('order_id')
            ->on('orders')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignUuid('received_by')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->date('date_received');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('received_by');
    }
};
