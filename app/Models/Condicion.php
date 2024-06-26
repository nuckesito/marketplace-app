<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condicion extends Model
{
  protected $table = 'condiciones';
  use HasFactory;
  
  public function anuncio()
  {
    return $this->hasOne(Anuncio::class);
  }
}
