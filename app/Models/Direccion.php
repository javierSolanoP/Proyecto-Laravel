<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;

    protected $fillable = [
                            'calle',
                            'departamento',
                            'municipio',
                            'codigo_postal',
                            'usuario_id'
    ];
}
