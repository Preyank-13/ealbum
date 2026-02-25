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
    Schema::create('galleries', function (Blueprint $table) {
        $table->id();
        $table->foreignId('studio_id')->constrained('studios')->onDelete('cascade');
        $table->json('images'); // Multiple photos ke liye JSON field
        $table->enum('status', ['active', 'disable'])->default('active');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
