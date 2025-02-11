<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Sale;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(\App\Http\Middleware\AdminMiddleware::class);  // Solo los admin pueden acceder a estas rutas
    }

    public function index()
    {
        return view('admin.index');
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users');
    }

    public function utilities()
    {
        // Obtener todos los anuncios y categorías
        $sales = Sale::all();  // o el filtro que necesites
        $categories = Category::all();

        // Pasar las variables a la vista
        return view('admin.utilities', compact('sales', 'categories'));
    }

    public function deleteSale($id)
    {
        Sale::findOrFail($id)->delete();
        return redirect()->route('admin.utilities');
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Category::create($request->all());
        return redirect()->route('admin.utilities')->with('success', 'Categoría añadida correctamente.');
    }

    public function cambiarVerificar($id)
{
    $user = User::findOrFail($id);
    
    // Si el usuario está verificado, desverificarlo, de lo contrario, verificarlo
    if ($user->email_verified_at) {
        $user->email_verified_at = null;  // Desverificar al usuario
        $status = 'Desverificado';
    } else {
        $user->email_verified_at = now();;  // Verificar al usuario
        $status = 'Verificado';
    }

    $user->save();
    return redirect()->route('admin.users')->with('status', 'Usuario ' . $status . ' correctamente.');
}
}
