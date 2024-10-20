<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Agenda;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'identificacion',
        'nombres',
        'apellidos',
        'correo',
        'direccion',
        'telefono',
        'tipocontrato',
        'datesemana',
    ];

    public function agendas()
    {
        return $this->hasMany(Agenda::class);
    }




}
