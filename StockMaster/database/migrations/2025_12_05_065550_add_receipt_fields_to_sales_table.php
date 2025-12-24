<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('receipt_number')->unique()->after('id');
            $table->decimal('tax_rate', 5, 2)->default(0)->after('total_amount');
            $table->decimal('tax_amount', 10, 2)->default(0)->after('tax_rate');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('tax_amount');
            $table->text('notes')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['receipt_number', 'tax_rate', 'tax_amount', 'discount_amount', 'notes']);
        });
    }
};
