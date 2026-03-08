<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Artisan;

// Página de inicio
Route::view('/', 'welcome');

// Panel principal
Route::get('/dashboard', \App\Livewire\Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Perfil del usuario
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Reportes y Salas
Route::get('/reportes/acta/{id}', [ReportController::class, 'exportTrainingMatrix'])
    ->middleware(['auth'])
    ->name('reports.matrix');

Route::get('/sala-virtual/{id}', \App\Livewire\VirtualClassroom::class)
    ->middleware(['auth'])
    ->name('virtual.room');

// --- RUTA INFALIBLE DE LOGOUT ---
// Destruye todo rastro de sesión y te obliga a ir al Login
Route::get('/salir', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('salir');

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

Route::get('/limpiar-vistas', function () {
    try {
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        return 'Visión restaurada. Ve a la página principal y presiona Ctrl + F5';
    } catch (\Exception $e) {
        return 'ERROR: ' . $e->getMessage();
    }
});

require __DIR__.'/auth.php';
