<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalPriceToReservationsTable extends Migration
{
public function up()
{
Schema::table('reservations', function (Blueprint $table) {
$table->decimal('total_price', 8, 2)->default(0)->after('status');
});
}

public function down()
{
Schema::table('reservations', function (Blueprint $table) {
$table->dropColumn('total_price');
});
}
}
