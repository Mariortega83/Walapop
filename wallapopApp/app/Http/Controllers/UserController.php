<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        // Obtener los anuncios del usuario autenticado
        $activeSales = Sale::where('user_id', Auth::id())
            ->where('isSold', false)
            ->get();
    
        $soldSales = Sale::where('user_id', Auth::id())
            ->where('isSold', true)
            ->get();
    
        // Pasar los datos a la vista
        return view('user.profile', compact('activeSales', 'soldSales'));
    }
    
}
