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
        Schema::table('laporan_perjalanan', function (Blueprint $table) {
            $table->unsignedBigInteger('validated_by')->nullable()->after('status');
            $table->foreign('validated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_perjalanan', function (Blueprint $table) {
            $table->dropForeign(['validated_by']);
            $table->dropColumn('validated_by');
        });
    }
};
