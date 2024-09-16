<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Agendamiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'numero',
        'nombre_tecnico',
        'tipo_agendamiento',
        'fecha_agendamiento',
        'hora_agendamiento',
        'numero_orden',
        'observaciones',
        'usuario_id',
        'numeroid',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id'); // Asegúrate de que el campo de la clave foránea sea correcto
    }

   public static function boot()
    {
        parent::boot();

        static::creating(function ($agendamiento) {
            // Obtener el último numeroid en la base de datos
            $lastNumeroId = DB::table('agendamientos')->max('numeroid');

            // Si no hay registros, empezar con 60000
            $nextNumeroId = $lastNumeroId ? $lastNumeroId + 1 : 60000;

            // Asignar el nuevo numeroid al registro
            $agendamiento->numeroid = $nextNumeroId;
        });
    } 


    public function setTipoAgendamientoAttribute($value)
    {
        $this->attributes['tipo_agendamiento'] = strtoupper($value);
    }

    public function setObservacionesAttribute($value)
    {
        $this->attributes['observaciones'] = strtoupper($value);
    }

}