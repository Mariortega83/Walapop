<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;

// Rutas de autenticación

Auth::routes(['verify' => true]);

// Ruta principal pública (sin verificación de correo)
Route::get('/', [SaleController::class, 'index'])->name('sales.index');

// Ruta del perfil, protegida por el middleware auth
Route::middleware('auth', 'verified')->get('/profile', [UserController::class, 'profile'])->name('user.profile');

// Rutas de ventas que requieren autenticación y verificación de correo
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::patch('/sales/{id}/cambiar-verificar', [SaleController::class, 'cambiarVerificar'])->name('sales.cambiarVerificar');
    Route::delete('sales/{sale}', [SaleController::class, 'destroy'])->name('sales.delete');
});

// Ruta pública para ver una venta
Route::get('/sales/{id}', [SaleController::class, 'show'])->name('sales.show');

// Rutas de administración, protegidas por auth y el middleware AdminMiddleware
Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class, 'verified'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/utilities', [AdminController::class, 'utilities'])->name('admin.utilities');
    Route::delete('/sales/{id}', [AdminController::class, 'deleteSale'])->name('admin.sales.delete');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::patch('/users/{id}/cambiar-verificar', [AdminController::class, 'cambiarVerificar'])->name('admin.users.cambiarVerificar');
});

// Eliminar categoría
Route::delete('admin/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.delete');


