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
        Schema::create('request_list', function (Blueprint $table) {
            $table->uuid('request_list_id')->primary();
            $table->foreignUuid('request_id')
                ->references('request_id')
                ->on('request')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignUuid('item_id')
                ->references('item_id')
                ->on('items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('status');
            $table->float('request_quantity')->nullable();
            $table->float('request_approved')->nullable();
            $table->float('request_disapproved')->nullable();
            $table->boolean('archived')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_list');
    }
};
