<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false; // Deshabilita los timestamps
    protected $fillable = ['name', 'maxImages'];
}
