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
        Schema::table('users', function (Blueprint $table) {
            // Plan status store karne ke liye
            $table->boolean('is_unlimited')->default(false)->after('credits');
            
            // 🟢 ADDED: Plan ka naam store karne ke liye (Basic, Pro, Studio)
            $table->string('active_plan')->nullable()->after('is_unlimited');
            
            // Plan ki expiry date
            $table->timestamp('plan_expires_at')->nullable()->after('active_plan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('users', function (Blueprint $table) {
        // Safe check: Pehle check karo column hai ya nahi, tabhi drop karo
        if (Schema::hasColumn('users', 'is_unlimited')) {
            $table->dropColumn('is_unlimited');
        }
        if (Schema::hasColumn('users', 'active_plan')) {
            $table->dropColumn('active_plan');
        }
        if (Schema::hasColumn('users', 'plan_expires_at')) {
            $table->dropColumn('plan_expires_at');
        }
    });
}
};