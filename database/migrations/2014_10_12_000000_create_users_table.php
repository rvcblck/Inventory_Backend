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


        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->string('suffix')->nullable();
            $table->date('bday')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_contact_no')->nullable();
            $table->string('address')->nullable();
            $table->string('delivery_location')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('logo')->nullable();
            $table->foreignUuid('role_id')
            ->references('role_id')
            ->on('roles')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
