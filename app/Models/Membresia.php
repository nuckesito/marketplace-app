<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'precio',
        'duracion',
        'etiqueta',
    ];

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
