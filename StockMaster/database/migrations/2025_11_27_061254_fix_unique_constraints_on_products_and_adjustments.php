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
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['code']);
            $table->unique(['user_id', 'code']);
        });

        Schema::table('adjustments', function (Blueprint $table) {
            $table->dropUnique(['reference']);
            $table->unique(['user_id', 'reference']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'code']);
            $table->unique(['code']);
        });

        Schema::table('adjustments', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'reference']);
            $table->unique(['reference']);
        });
    }
};
