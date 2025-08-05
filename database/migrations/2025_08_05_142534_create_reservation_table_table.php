<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
Schema::create('reservation_table', function (Blueprint $table) {
$table->id();
$table->foreignId('reservation_id')->constrained()->onDelete('cascade');
$table->foreignId('table_id')->constrained()->onDelete('cascade');
$table->timestamps();

$table->unique(['reservation_id', 'table_id']); // Aynı kayıt tekrar olmasın diye
});
}

public function down(): void
{
Schema::dropIfExists('reservation_table');
}
};
