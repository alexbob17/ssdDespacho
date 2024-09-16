<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Consulta extends Model
{
    protected $table = 'consultas';
    
    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'codigo_tecnico',
        'numero',
        'nombre_tecnico',
        'motivo_consulta',
        'numero_orden',
        'observaciones',
        'idconsulta',
        'user_id',
    ];

    public static function boot()
    {
        parent::boot();
    
        static::creating(function ($consulta) {
            // Obtener el siguiente ID de consulta utilizando DB::raw
            $nextId = DB::table('consultas')
                ->selectRaw('IFNULL(MAX(idconsulta), 399999) + 1 AS next_id')
                ->value('next_id');
    
            // Asignar el nuevo ID de consulta al registro
            $consulta->idconsulta = $nextId;
        });
    }

 /*   public static function boot()
    {
        parent::boot();

        static::creating(function ($consulta) {
            // Obtener el último ID de consulta en la base de datos
            $lastId = DB::table('consultas')->max('idconsulta');

            // Si no hay registros, empezar con 400000
            $nextId = $lastId ? $lastId + 1 : 400000;

            // Asignar el nuevo ID de consulta al registro
            $consulta->idconsulta = $nextId;
        });
    } */
    

    public function setObservacionesAttribute($value)
    {
        $this->attributes['observaciones'] = strtoupper($value);
    }

   // En el modelo Consulta

   /*
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    */

    public function user()
{
    return $this->belongsTo(User::class, 'user_id'); // Asegúrate de que el campo clave foránea sea 'user_id'
}


    

}