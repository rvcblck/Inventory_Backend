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
        Schema::create('request', function (Blueprint $table) {
            $table->uuid('request_id')->primary();
            $table->integer('request_number');
            $table->string('qr_code');
            $table->foreignUuid('company_id')
                ->references('company_id')
                ->on('company')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignUuid('requestor_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->longText('message')->nullable();
            $table->date('date_needed')->nullable();
            $table->string('transaction_type')->nullable(); // Deliver, Pick up, Either Pick Up Or Deliver
            $table->boolean('admin_checked')->nullable(); // is admin checked and ready to post the request
            $table->boolean('archived')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request');
    }
};
