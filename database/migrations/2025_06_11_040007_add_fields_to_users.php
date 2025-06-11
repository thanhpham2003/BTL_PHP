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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->integer('total_order')->default(0)->nullable();
            $table->decimal('total_price', 10, 2)->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('phone_number');
            $table->dropColumn('address');
            $table->dropColumn('total_order');
            $table->dropColumn('total_price');
        });
    }
};
