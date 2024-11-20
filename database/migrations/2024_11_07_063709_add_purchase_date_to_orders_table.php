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
        // Check if the column does not exist before adding it
        if (!Schema::hasColumn('orders', 'purchase_date')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->date('purchase_date')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if the column exists before dropping it
        if (Schema::hasColumn('orders', 'purchase_date')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('purchase_date');
            });
        }
    }
};