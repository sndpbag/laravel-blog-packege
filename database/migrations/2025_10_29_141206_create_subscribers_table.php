<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index(); // ব্যবহারকারীর ID (যদি থাকে)
            $table->string('email')->unique();
            $table->string('verification_token')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamps();

            // আপনার ইউজার টেবিলের নাম 'users' হলে নিচের লাইনটি রাখুন
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};