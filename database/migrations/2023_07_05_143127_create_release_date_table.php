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
        Schema::create('release_date', function (Blueprint $table) {
            $table->uuid('release_date_id')->primary();
            $table->foreignUuid('order_list_id')
                ->references('order_list_id')
                ->on('order_list')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('status')->nullable(); //incomplete or complete
            $table->float('quantity')->nullable(); //ilan yung yung idedeliver
            $table->dateTime('release_date')->nullable(); // kailan na release ni supplier
            $table->dateTime('receive_date')->nullable(); // kailan na recieved
            $table->boolean('is_checked_warehouse')->default(false);  // checked by warehouse?
            $table->boolean('archived')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('release_date');
    }
};
