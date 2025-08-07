<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')->constrained('tables')->onDelete('cascade');
            $table->string('name');
            $table->string('surname');
            $table->string('email');  // ->after('surname') KALDIRILDI
            $table->dateTime('datetime');
            $table->dateTime('end_datetime')->nullable();  // Burayı ekledik
            $table->integer('people')->default(1);
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'reserved', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
