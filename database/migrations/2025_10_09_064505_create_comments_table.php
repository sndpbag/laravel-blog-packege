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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('blog_id');
            $table->unsignedBigInteger('user_id')->nullable();  
            $table->text('body');
            $table->unsignedBigInteger('parent_id')->nullable(); // রিপ্লাই এর জন্য
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
          

            // Foreign keys
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
