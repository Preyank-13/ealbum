<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('credits', function (Blueprint $table) {
        $table->id();
        // 🟢 Sabse zaroori: user_id column yahan define hota hai
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        $table->string('order_id')->nullable();
        $table->timestamp('purchase_date')->nullable();
        $table->string('album_name')->nullable();
        $table->integer('credits');
        $table->decimal('amount', 10, 2);
        $table->string('payment_type');
        $table->text('message')->nullable();
        $table->string('status');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};
