<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        // Obtener la categoría seleccionada
        $categoryId = $request->input('category_id');
    
        // Obtener todas las categorías para el filtro
        $categories = Category::all();
    
        // Obtener los anuncios que no estén vendidos y aplicar el filtro por categoría
        $query = Sale::with('category', 'images', 'user')->where('isSold', false);
    
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
    
        $sales = $query->get();
    
        return view('sales.index', compact('sales', 'categories'));
    }
    


    public function create()
    {
        $categories = Category::all();
        $maxImages = Setting::first()->maxImages;
        return view('sales.create', compact('categories', 'maxImages'));
    }

    public function store(Request $request)
    {
        $settings = Setting::first();
        $maxImages = $settings->maxImages;

        // Validar los datos del formulario
        $request->validate([
            'product' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'images' => 'required|array|max:' . $maxImages, 
            'images.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048', 
            
        ]);

        // Crear el anuncio
        $sale = Sale::create([
            'product' => $request->product,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(), 
        ]);

        // Subir y asociar las imágenes
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            // Si se envían varias imagenes, asigna la primera al campo 'img'
            $firstImage = array_shift($images);
            $firstPath = $firstImage->store('images', 'public');

            // Actualiza el campo 'img' de la venta con la ruta de la primera imagen
            $sale->update(['img' => $firstPath]);

            Image::create([
                'sale_id' => $sale->id,
                'ruta' => $firstPath,
            ]);

            // Guarda las imágenes restantes, si existen
            foreach ($images as $image) {
                $path = $image->store('images', 'public');
                Image::create([
                    'sale_id' => $sale->id,
                    'ruta' => $path,
                ]);
            }
        }

        return redirect()->route('sales.index')->with('success', 'Anuncio creado correctamente.');
    }

    public function show($id)
    {
        $sale = Sale::with(['category', 'images', 'user'])->findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    public function cambiarVerificar($id)
    {
        $sale = Sale::findOrFail($id);

        // Alternar el estado de isSold
        $sale->isSold = !$sale->isSold; // Cambia true a false o viceversa
        $sale->save();

        return redirect()->route('user.profile')->with(
            'status',
            'El estado del anuncio ha sido actualizado a ' . ($sale->isSold ? 'vendido' : 'no vendido') . '.'
        );
    }


    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
    
        // Verificar que el usuario sea el propietario del anuncio o admin
        if ($sale->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }
    
        // Eliminar las imágenes asociadas
        foreach ($sale->images as $image) {
            Storage::delete($image->ruta); // Elimina el archivo del almacenamiento
            $image->delete(); // Elimina el registro de la base de datos
        }
    
        // Eliminar el anuncio
        $sale->delete();
    
        return redirect()->back()->with('success', 'Anuncio eliminado correctamente.');
    }
    
}
