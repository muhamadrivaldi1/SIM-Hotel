<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checkins', function (Blueprint $table) {
            $table->decimal('total_price', 12, 2)->default(0);
        });
    }

    public function down()
    {
        Schema::table('checkins', function (Blueprint $table) {
            $table->dropColumn('total_price');
        });
    }
};
