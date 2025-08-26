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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama kamar, misal "Room 101"
            $table->string('number')->unique(); // Nomor kamar unik
            $table->string('type'); // Tipe kamar, misal "Single", "Double"
            $table->enum('status', ['Available', 'Occupied', 'Cleaning', 'Locked'])->default('Available'); // Status kamar
            $table->string('barcode_key')->unique(); // Barcode unik
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
