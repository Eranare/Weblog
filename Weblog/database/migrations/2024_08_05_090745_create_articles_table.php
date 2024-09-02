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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('content_file_path'); //Link to content saved in storage
            $table->string('banner_image_path')->nullable(); //Image to be displayed on Home page.
            $table->string('content_preview');
            $table->foreignId('user_id'); //Author
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_flagged_for_deletion')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
