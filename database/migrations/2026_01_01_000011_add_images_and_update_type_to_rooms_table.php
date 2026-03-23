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

        // Ukloni stari check constraint i dozvoli nove tipove (PostgreSQL)
        DB::statement("ALTER TABLE rooms DROP CONSTRAINT IF EXISTS rooms_type_check");
        DB::statement("ALTER TABLE rooms ALTER COLUMN type TYPE VARCHAR(50)");
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};
