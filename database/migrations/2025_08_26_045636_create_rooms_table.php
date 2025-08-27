<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained('guests')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->dateTime('checkin_date');
            $table->dateTime('checkout_date')->nullable();
            $table->enum('status', ['CheckedIn', 'CheckedOut'])->default('CheckedIn');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkins');
    }
};
