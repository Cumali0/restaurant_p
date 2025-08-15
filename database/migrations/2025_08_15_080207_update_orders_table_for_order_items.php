<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Eğer menu_id varsa önce foreign key kaldır
            if (Schema::hasColumn('orders', 'menu_id')) {
                $table->dropForeign(['menu_id']); // FK kaldır
                $table->dropColumn('menu_id');    // Column kaldır
            }

            // quantity ve price kolonlarını kaldır
            if (Schema::hasColumn('orders', 'quantity')) $table->dropColumn('quantity');
            if (Schema::hasColumn('orders', 'price')) $table->dropColumn('price');

            // Yeni kolonları ekle
            if (!Schema::hasColumn('orders', 'total_price'))
                $table->decimal('total_price', 10, 2)->default(0)->after('reservation_id');

            if (!Schema::hasColumn('orders', 'payment_status'))
                $table->enum('payment_status', ['unpaid','paid'])->default('unpaid')->after('total_price');

            if (!Schema::hasColumn('orders', 'payment_method'))
                $table->string('payment_method')->nullable()->after('payment_status');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Eski kolonları geri ekle
            if (!Schema::hasColumn('orders', 'menu_id')) $table->foreignId('menu_id')->nullable()->constrained()->onDelete('cascade');
            if (!Schema::hasColumn('orders', 'quantity')) $table->integer('quantity')->nullable();
            if (!Schema::hasColumn('orders', 'price')) $table->decimal('price', 8, 2)->nullable();

            // Yeni eklenen kolonları kaldır
            if (Schema::hasColumn('orders', 'total_price')) $table->dropColumn('total_price');
            if (Schema::hasColumn('orders', 'payment_status')) $table->dropColumn('payment_status');
            if (Schema::hasColumn('orders', 'payment_method')) $table->dropColumn('payment_method');
        });
    }
};
