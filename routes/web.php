<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\BusinessDirectoryController;
use App\Http\Controllers\DataModels;
use App\Http\Controllers\serviceController;
use App\Http\Controllers\ExchangeRateController;
use App\Livewire\BusinessDirectory;

// Ruta para la página de inicio
// Route::get('/', function () { //maneja las solicitudes a la raíz de tu aplicación. Aquí se define que, al acceder al dominio principal, se mostrará la vista de login.
    // return view('auth/login');
//     return view('register');
// })->name('home');//nombre de la ruta

////Grupo de rutas protegidas por autenticación
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Ruta para el dashboard
    /*Route::get('/', function () {
       return view('/dashboard');
   })->name('home');

    Route::get('/dashboard', function () {
         return view('/dashboard');
     })->name('dashboard.page');*/
    Route::get('/', App\Livewire\Shipment\ListShipments::class)->name('dashboard');

    // Ruta para reports
    Route::get('/reports', function () {
        return "reports";//view('dashboard');
    })->name('reports');

    // Ruta para catalogo
    // Route::get('/catalog', function () {
    //     return view('catalog.index');
    // })->name('catalog');

    // // Ruta para directory
    // Route::get('/directory', function () {
    //     return view('dashboard');
    // })->name('directory');
    Route::resource('exchange-rates', ExchangeRateController::class);
    // Ruta de los servicios
    Route::resource('services', serviceController::class);

    // Grupo de rutas para Administración
    // Grupo de rutas para Administración de Usuarios (solo accesible por admin)
    Route::middleware(['auth', 'can:users.index'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
    });

    Route::middleware(['auth', 'can:catalog.index'])->group(function () {
        Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
    });


    // Route::resource('business-directory', BusinessDirectoryController::class);
    // Route::resource('users', UserController::class);
    Route::get('business-directory', [BusinessDirectoryController::class, 'index'])->name('business-directory.index');
    Route::get('/business-directory/create', [BusinessDirectoryController::class, 'createDirectory'])->name('business-directory.create');
    Route::post('/business-directory/store', [BusinessDirectoryController::class, 'storeDirectory'])->name('business-directory.store');
    Route::get('business-directory/{id}/edit', [BusinessDirectoryController::class, 'edit'])->name('business-directory.edit');
    Route::put('business-directory/{id}', [BusinessDirectoryController::class, 'update'])->name('business-directory.update');

    // Ruta para mostrar el formulario de agregar contactos
    Route::get('/business-directory/{id}/contacts/details', [BusinessDirectoryController::class, 'ContactDetails'])->name('business-directory.contacts.contact-details');

    Route::get('business-directory/{id}/contacts', [BusinessDirectoryController::class, 'showContacts'])->name('business-directory.contacts.index');


    // Ruta para guardar el contacto
    Route::post('/business-directory/{id}/contacts/store', [BusinessDirectoryController::class, 'storeContact'])->name('business-directory.contacts.store');
    Route::get('/business-directory/create2', App\Livewire\BusinessDirectory\CreateBusinessDirectory::class)->name('business-directory.create2');
    Route::get('/shipment/form', App\Livewire\Shipment\CreateShipment::class)->name('shipment.form');
    Route::get('/shipment/dash', App\Livewire\Shipment\ListShipments::class)->name('shipment.dashboard');
    Route::get('/datamodel/equipment',[DataModels::class,'sup_equipment']);
});
