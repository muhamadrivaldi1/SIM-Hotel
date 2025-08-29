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
        Schema::table('h_r_d_employees', function (Blueprint $table) {
            $table->string('name', 150)->after('id');
            $table->string('position', 100)->after('name');
            $table->decimal('salary', 15, 2)->after('position');
            $table->enum('status', ['Active', 'Inactive'])->default('Active')->after('salary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('h_r_d_employees', function (Blueprint $table) {
            $table->dropColumn(['name', 'position', 'salary', 'status']);
        });
    }
};
