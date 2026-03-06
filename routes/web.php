<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Artisan;

// Página de inicio
Route::view('/', 'welcome');

// Panel principal (Protegido, solo usuarios logueados)
Route::get('/dashboard', \App\Livewire\Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Perfil del usuario
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// --- RUTA PARA DESCARGAR EL PDF (ACTA OFICIAL) ---
Route::get('/reportes/acta/{id}', [ReportController::class, 'exportTrainingMatrix'])
    ->middleware(['auth'])
    ->name('reports.matrix');

// --- RUTA DEL SALÓN VIRTUAL DE TRANSMISIÓN (JITSI) ---
Route::get('/sala-virtual/{id}', \App\Livewire\VirtualClassroom::class)
    ->middleware(['auth'])
    ->name('virtual.room');

// --- NUESTRA RUTA DE LOGOUT PERSONALIZADA ---
Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Rutas exclusivas del Administrador
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/sedes', \App\Livewire\Admin\CampusManagement::class)->name('admin.sedes');
    Route::get('/admin/cursos', \App\Livewire\Admin\TrainingManagement::class)->name('admin.cursos');
    Route::get('/admin/usuarios', \App\Livewire\Admin\UserManagement::class)->name('admin.usuarios');
    Route::get('/admin/inscripciones', \App\Livewire\Admin\EnrollmentManagement::class)->name('admin.inscripciones');
    Route::get('/admin/calificaciones', \App\Livewire\Admin\GradeManagement::class)->name('admin.calificaciones');
});

// Rutas exclusivas para Estudiantes
Route::middleware(['auth', 'role:estudiante'])->group(function () {
    Route::get('/mis-cursos', \App\Livewire\Student\MyCourses::class)->name('student.cursos');
    Route::get('/mis-cursos/certificado/{id}', [App\Http\Controllers\ReportController::class, 'exportStudentCertificate'])->name('student.certificate');
});

// Rutas exclusivas para Profesores
Route::middleware(['auth', 'role:profesor'])->group(function () {
    Route::get('/mis-clases', \App\Livewire\Teacher\MyClasses::class)->name('teacher.clases');
});

// RUTA MAESTRA: LIMPIA CACHÉ E INSTALA BASE DE DATOS
Route::get('/iniciar-todo', function () {
    try {
        // 1. Fulminar la caché rebelde de la Landing Page
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');

        // 2. Construir y poblar la nueva base de datos PostgreSQL
        Artisan::call('migrate:fresh', [
            '--force' => true,
            '--seed' => true
        ]);

        return '¡MISIÓN CUMPLIDA! Caché purgada y Base de Datos PostgreSQL construida. Ya puedes ir a la página principal.';
    } catch (\Exception $e) {
        return 'ERROR: ' . $e->getMessage();
    }
});

require __DIR__.'/auth.php';
