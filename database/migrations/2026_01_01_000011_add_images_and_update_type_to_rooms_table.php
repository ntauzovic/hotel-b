<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->json('images')->nullable()->after('amenities'); // Slike sobe (array URL-ova)
        });

        // Update the type enum to include new types
        DB::statement("ALTER TABLE rooms MODIFY COLUMN type ENUM('standard', 'superior', 'deluxe', 'junior_suite', 'penthouse', 'single', 'double', 'suite', 'apartment')");
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};
