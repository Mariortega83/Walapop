<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Sale extends Model
{
    protected $fillable = ['category_id', 'user_id', 'product', 'description', 'price', 'isSold', 'img'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($sale) {
            // Eliminar las imágenes asociadas en el storage
            foreach ($sale->images as $image) {
                Storage::delete($image->ruta); // Elimina la foto del almacenamiento
            }

            // Opcional: si deseas eliminar la miniatura (si es un archivo y no binario)
            if ($sale->img && Storage::exists($sale->img)) {
                Storage::delete($sale->img); // Elimina la miniatura del almacenamiento
            }
        });
    }
}
