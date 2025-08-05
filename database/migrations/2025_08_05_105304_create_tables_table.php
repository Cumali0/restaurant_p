<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('name');                   // Masa adı veya numarası
            $table->integer('capacity')->default(4); // Varsayılan kapasite
            $table->enum('status', ['active', 'inactive'])->default('active'); // Masa aktifliği
            $table->string('floor')->nullable();     // Kat bilgisi (opsiyonel)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};


