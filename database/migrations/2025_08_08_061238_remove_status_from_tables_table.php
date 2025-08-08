<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveStatusFromTablesTable extends Migration
{
public function up(): void
{
Schema::table('tables', function (Blueprint $table) {
$table->dropColumn('status');
});
}

public function down(): void
{
Schema::table('tables', function (Blueprint $table) {
    $table->enum('status', ['available', 'booked'])->default('available');
});
}
}
