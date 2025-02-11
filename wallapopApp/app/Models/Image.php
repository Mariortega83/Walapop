<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['sale_id', 'ruta'];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
