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
    Schema::create('studios', function (Blueprint $table) {
        $table->id(); // Primary Key
        
        // --- YAHAN APNI FIELDS DALNI HAIN ---
        $table->string('studio_name');
        $table->string('contact_person');
        $table->string('studio_email');
        $table->string('studio_contact');
        $table->string('experience');
        // ------------------------------------

        $table->timestamps(); // Created_at & Updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studios');
    }
};
