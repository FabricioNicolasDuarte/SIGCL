<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_id')->constrained()->onDelete('cascade');
            $table->foreignId('enrollment_id')->constrained()->onDelete('cascade');
            $table->decimal('score', 5, 2)->nullable(); // La nota real del alumno
            $table->timestamps();

            // Regla de seguridad: Un alumno no puede tener dos notas en el mismo examen
            $table->unique(['evaluation_id', 'enrollment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
