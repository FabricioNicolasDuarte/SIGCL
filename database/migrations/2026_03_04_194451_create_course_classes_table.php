<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('course_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Ej: "Clase 1: Introducción"
            $table->date('date');   // La fecha exacta en la que se dictará
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('course_classes');
    }
};
