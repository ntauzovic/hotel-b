<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();

            // Osnovni podaci
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();

            // Licni podaci
            $table->date('date_of_birth')->nullable();
            $table->string('nationality')->nullable();
            $table->string('passport_number')->nullable()->unique();

            // Adresa
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();

            // Napomene o gostu (VIP, alergije, preferencije...)
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
