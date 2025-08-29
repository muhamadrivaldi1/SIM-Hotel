
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('finances', function (Blueprint $table) {
            $table->enum('transaction_type', ['Income', 'Expense'])->after('id');
            $table->decimal('amount', 15, 2)->after('transaction_type');
            $table->string('description')->after('amount');
            $table->date('date')->after('description');
        });
    }

    public function down()
    {
        Schema::table('finances', function (Blueprint $table) {
            $table->dropColumn(['transaction_type', 'amount', 'description', 'date']);
        });
    }
};
