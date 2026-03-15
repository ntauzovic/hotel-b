<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');                         // Naziv sobe npr. "101", "Deluxe Suite"
            $table->enum('type', [                          // Tip sobe
                'single',
                'double',
                'suite',
                'apartment'
            ]);
            $table->text('description')->nullable();        // Opis sobe
            $table->decimal('price_per_night', 10, 2);     // Cijena po nocenju
            $table->integer('capacity');                    // Maksimalni broj gostiju
            $table->integer('floor')->nullable();           // Sprat
            $table->boolean('is_available')->default(true); // Da li je soba dostupna
            $table->json('amenities')->nullable();          // Sadrzaj sobe (TV, WiFi, mini bar...)
            $table->timestamps();                           // created_at i updated_at
            $table->softDeletes();                          // deleted_at (soft delete - ne brise iz baze)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
