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
        Schema::table('patients', function (Blueprint $table) {
        $table->string('pr_no')->nullable()->after('id'); // Random patient record number
            $table->string('mobile')->nullable()->after('email'); // Mobile number
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
        $table->dropColumn(['pr_no', 'mobile']);
        });
    }
};
