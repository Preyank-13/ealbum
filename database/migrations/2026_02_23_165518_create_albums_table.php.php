<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::create('albums', function (Blueprint $table) {
        $table->id();
        // Foreign Key jo Studio ki ID ko point karegi
        $table->foreignId('studio_id')->constrained('studios')->onDelete('cascade');
        $table->string('album_name');
        $table->string('album_type');
        $table->string('unique_code')->unique();
        $table->string('cover_photo')->nullable();
        $table->string('album_song')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
