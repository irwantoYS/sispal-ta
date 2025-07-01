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
        Schema::create('dcu_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('shift', ['Pagi', 'Malam']);
            $table->integer('sistolik');
            $table->integer('diastolik');
            $table->integer('nadi');
            $table->integer('pernapasan');
            $table->float('spo2');
            $table->float('suhu_tubuh');
            $table->string('mata');
            $table->enum('kesimpulan', ['Fit', 'Unfit']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dcu_records');
    }
};
