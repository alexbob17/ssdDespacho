<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TecnicoController;
use App\Exports\TecnicosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\EditarConsultasController;
use App\Http\Controllers\ConsultaController;
use App\Exports\ConsultasExport;
use App\Http\Controllers\AgendamientoController;
use App\Http\Controllers\InstalacionController;
use App\Http\Controllers\ReparacionController;
use App\Http\Controllers\PostventasController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\AnulacionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;




Route::get('/', fn() => redirect('/login'));
Auth::routes();

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('auth');;
Route::post('register', [RegisterController::class, 'register'])->middleware('auth');;
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');


Route::prefix('users')->name('users.')->middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('{user}', [UserController::class, 'update'])->name('update');
    Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
    Route::post('{id}/reset-password', [UserController::class, 'resetPassword'])->name('reset-password');
});


Route::prefix('tecnicos')->name('tecnicos.')->middleware('auth')->group(function () {
    Route::get('/', [TecnicoController::class, 'index'])->name('index');
    Route::get('create', [TecnicoController::class, 'create'])->name('create');
    Route::post('/', [TecnicoController::class, 'store'])->name('store');
    Route::get('{id}/edit', [TecnicoController::class, 'edit'])->name('edit');
    Route::put('{id}', [TecnicoController::class, 'update'])->name('update');
    Route::delete('{tecnico}', [TecnicoController::class, 'destroy'])->name('destroy');
    Route::get('export', fn() => Excel::download(new TecnicosExport, 'tecnicos.xlsx'))->name('export');
});


Route::middleware('auth')->group(function () {
    Route::resource('consultas', ConsultaController::class);
    Route::get('consultas/tecnico/{codigo}', [ConsultaController::class, 'getTecnico'])->name('consultas.tecnico');
    Route::get('consultas/hoy', [ConsultaController::class, 'consultasHoy'])->name('consultas.hoy');
    Route::get('consultas/export', fn() => Excel::download(new ConsultasExport, 'consultas.xlsx'))->name('consultas.export');
});



//Editar consultas
Route::resource('editarconsultas', EditarConsultasController::class)->middleware('auth');

Route::get('/test-timezone', fn() => response()->json([
    'now' => now(),
    'php_timezone' => date_default_timezone_get(),
]));


//Agendamientos

Route::prefix('agendamientos')->middleware('auth')->group(function () {
    Route::get('/', [AgendamientoController::class, 'index'])->name('agendamientos.index');
    Route::post('/', [AgendamientoController::class, 'store'])->name('agendamientos.store');
    Route::get('/agendamientos/{codigo}', [AgendamientoController::class, 'getTecnico'])->name('agendamientos.tecnico');
});


//Instalaciones

Route::middleware(['auth'])->group(function () {
    Route::get('/instalaciones', [InstalacionController::class, 'index'])->name('instalaciones.index');
    Route::get('/instalaciones/{codigo}', [InstalacionController::class, 'getTecnico'])->name('instalaciones.tecnico');
    Route::post('/instalaciones', [InstalacionController::class, 'store'])->name('instalaciones.store');
});

//Reparaciones

 Route::middleware('auth')->group(function (){
    Route::get('/reparaciones', [ReparacionController::class, 'index'])->name('reparaciones.index');
    Route::get('/reparaciones/{codigo}', [ReparacionController::class, 'getTecnico'])->name('reparaciones.tecnico');
    Route::post('/reparaciones', [ReparacionController::class, 'store'])->name('reparaciones.store');
 });

 Route::get('/postventas', [PostventasController::class, 'index'])->name('postventas.index')->middleware('auth');

 Route::post('/postventas', [PostventasController::class, 'store'])->name('postventas.store')->middleware('auth');

 Route::get('/busqueda', [BusquedaController::class, 'index'])->name('busqueda.index')->middleware('auth');

 Route::get('/edit/{type}/{id}', [BusquedaController::class, 'edit'])->name('edit')->middleware('auth');


 Route::put('instalaciones/{id}', [InstalacionController::class, 'update'])->name('instalaciones.update')->middleware('auth');
 Route::put('reparaciones/{id}', [ReparacionController::class, 'update'])->name('reparaciones.update')->middleware('auth');
 Route::put('postventa/{id}', [PostventasController::class, 'update'])->name('postventa.update')->middleware('auth');

 Route::resource('editanulacion', AnulacionController::class)->middleware('auth')->middleware('auth');
 
 Route::get('reports', [ReportController::class, 'index'])->name('reports.index')->middleware('auth');
 Route::post('reports', [ReportController::class, 'getReportData'])->name('reports.getData')->middleware('auth');
 Route::get('reports/result', [ReportController::class, 'showResult'])->name('reports.result')->middleware('auth');


// Ruta para mostrar el formulario de cambio de contraseña
Route::get('users/passwordchange', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');

// Ruta para procesar el cambio de contraseña
Route::post('users/passwordchange', [ProfileController::class, 'changePassword'])->name('profile.update-password');

// Ruta para resetear la contraseña a un valor predeterminado
Route::post('users/passwordreset', [ProfileController::class, 'resetPassword'])->name('profile.reset-password');
 
 