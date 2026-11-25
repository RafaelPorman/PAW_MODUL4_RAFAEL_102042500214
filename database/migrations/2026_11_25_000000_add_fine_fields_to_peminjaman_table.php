<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->date('tanggal_jatuh_tempo')->nullable()->after('tanggal_kembali');
            $table->date('tanggal_pengembalian_aktual')->nullable()->after('tanggal_jatuh_tempo');
            $table->unsignedBigInteger('denda')->default(0)->after('tanggal_pengembalian_aktual');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn(['tanggal_jatuh_tempo', 'tanggal_pengembalian_aktual', 'denda']);
        });
    }
};
