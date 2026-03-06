<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_class_id')->constrained()->onDelete('cascade'); // AHORA LA ASISTENCIA ESTÁ ATADA A LA CLASE PROGRAMADA
            $table->time('entry_time')->nullable();
            $table->time('exit_time')->nullable();
            $table->string('status')->default('present');
            $table->timestamps();

            // Un alumno no puede tener dos asistencias en la misma clase
            $table->unique(['enrollment_id', 'course_class_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('attendances');
    }
};
