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
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('preorder_token', 64)->unique()->after('is_preorder');
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('reservations', 'preorder_token')) {
            Schema::table('reservations', function (Blueprint $table) {
                $table->dropColumn('preorder_token');
            });
        }
    }
};
