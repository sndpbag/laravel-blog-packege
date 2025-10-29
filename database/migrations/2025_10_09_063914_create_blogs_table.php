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
        // 1️⃣ blog_categories table

        Schema::create('blog_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
             $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->softDeletes(); // 🗑️ Trash/Recycle Bin
            $table->timestamps();
        });





        // 2️⃣ blogs table
        Schema::create('blogs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();

            // Foreign key for category
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')
                ->references('id')
                ->on('blog_categories')
                ->onDelete('set null');

            // Polymorphic relationship for author (e.g., Member, Admin)
            $table->morphs('author');
            $table->unsignedBigInteger('member_id')->nullable();

            // Blog content and details
            $table->string('image')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content');

            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            // Other details
            $table->text('tags')->nullable(); // Tags, can be stored as comma-separated values
            $table->unsignedInteger('likes')->default(0);
            $table->unsignedInteger('views')->default(0); // Added view count
            $table->boolean('is_featured')->default(false); // Added for featured posts
            $table->unsignedInteger('reading_time')->nullable();
            $table->unsignedInteger('word_count')->nullable();

            // Status and Dates
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->date('published_date')->nullable();

            $table->dateTime('scheduled_at')->nullable();
            $table->softDeletes(); // 🗑️ Trash/Recycle Bin
            $table->timestamps();
        });

        // blog likes
           Schema::create('blog_likes', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('user_id'); // কে লাইক দিয়েছেন তার আইডি
            $table->morphs('likeable'); // এই দুটি কলাম ব্লগ পোস্ট বা কমেন্টের আইডি ও মডেলের নাম সংরক্ষণ করবে।
            

            // Foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
 
            $table->unique(['user_id', 'likeable_id', 'likeable_type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('blog_categories');
        Schema::dropIfExists('blog_likes');
    }
};
