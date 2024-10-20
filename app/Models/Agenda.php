<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
    'nombres',
    'correo',
    'telefono',
    'tiposervicio',
    'fecha',
    'empleado_id'  // Asegúrate de que este campo esté presente, no 'empleado'
];

  public function empleado()
{
    return $this->belongsTo(Empleado::class);
}


     
}
