<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\AgendaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleAssignmentController;

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// Rutas públicas para la creación de empleados y citas
Route::post('/empleado', [EmpleadoController::class, 'store'])->name('empleado.store');
Route::post('/agendacita', [AgendaController::class, 'store'])->name('agendacita.store');

// Rutas protegidas por autenticación
Route::middleware(['auth', 'verified'])->group(function () {
    // Ruta del dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas para el perfil del usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Vistas relacionadas con empleados
    Route::get('/empleado', function() {
        return view('empleado.index');
    })->name('empleado.index');


    //Rutas de Empleados

    Route::get('/listaEmpleado', [EmpleadoController::class, 'show'])->name('listaEmpleado.index');
    Route::get('/citasAgendadas', [AgendaController::class, 'show'])->name('citasAgendadas.index');
   


    //Ruta de Roles
// Mostrar la lista de usuarios y roles
// Ruta para mostrar la lista de roles
Route::get('/listado-roles', [RoleAssignmentController::class, 'showRoles'])->name('listadoRoles.index');

// Ruta para mostrar la lista de permisos
Route::get('/listado-permisos', [RoleAssignmentController::class, 'index'])->name('listadoPermisos.index');

// Asignar un rol a un usuario
Route::post('/roles/assign', [RoleAssignmentController::class, 'assignRole'])->name('roles.assign');

// Eliminar un rol de un usuario
Route::post('/roles/remove', [RoleAssignmentController::class, 'removeRole'])->name('roles.remove');

Route::put('/roles/{id}', [RoleAssignmentController::class, 'update'])->name('roles.update');


// Almacenar un nuevo rol
Route::post('/roles/store', [RoleAssignmentController::class, 'store'])->name('roles.store');

// Eliminar un rol existente
Route::delete('/roles/{id}', [RoleAssignmentController::class, 'destroy'])->name('roles.destroy');




    // DATOS DE LA AGENDA ACTUALIZAR EDITAR ELIMINAR  
    Route::delete('/deleteCitas/{id}', [AgendaController::class, 'destroy'])->name('deleteCitas.destroy');
    Route::put('/updateAgendado/{id}', [AgendaController::class, 'update'])->name('updateAgendado.update');
    Route::get('/editarAgendados/{id}', [AgendaController::class, 'editAgendado'])->name('editarAgendados.index');
    Route::get('/agendafecha/{empleadoId}', [AgendaController::class, 'show'])->name('agendacita.index');

   





    // Rutas para manejar empleados (editar, actualizar y eliminar)
    Route::get('/editarEmpleados/{id}', [EmpleadoController::class, 'mostrarEdit'])->name('editarEmpleados.index');
    Route::put('/updatempleado/{id}', [EmpleadoController::class, 'update'])->name('updatempleado.update');
    Route::delete('/deleteEmpleado/{id}', [EmpleadoController::class, 'destroy'])->name('deleteEmpleado.destroy');



    // Rutas Agedas
    Route::get('/agendafecha/{empleadoId}', [AgendaController::class, 'show'])->name('agendacita.index');
      Route::get('/empleado/{empleadoId}/fechas', [AgendaController::class, 'getEmpleadoFecha'])->name('empleado.fechas');
    Route::get('/agendacita', [AgendaController::class, 'index'])->name('agendacita.index');
    
});

// Autenticación (rutas generadas por Laravel)
require __DIR__ . '/auth.php';
