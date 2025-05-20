<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("UPDATE products SET thumb = REPLACE(thumb, '/storage/uploads/', 'uploads/') WHERE thumb LIKE '/storage/uploads/%'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE products SET thumb = REPLACE(thumb, 'uploads/', '/storage/uploads/') WHERE thumb LIKE 'uploads/%'");
    }
};
