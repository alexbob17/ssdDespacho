<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Secuencia;


class Instalaciones extends Model
{
    use HasFactory;
    
    protected $table = 'instalaciones_realizadas'; // Nombre de la tabla en la base de datos


    protected $fillable = [
        'codigo',
        'numero',
        'nombre_tecnico',
        'tipoOrden',
        'depto',
        'tipoactividad',
        'ordenTv',
        'ordenInternet',
        'ordenLinea',
        'equiposTvnumero1',
        'equiposTvnumero2',
        'equiposTvnumero3',
        'equiposTvnumero4',
        'equiposTvnumero5',
        'smartcardnumero1',
        'smartcardnumero2',
        'smartcardnumero3',
        'smartcardnumero4',
        'smartcardnumero5',
        'equipoModem',
        'coordenadas',
        'numeroLinea',
        'observaciones',
        'recibe',
        'nodo',
        'tapCaja',
        'posicion',
        'materiales',
        'status',
        'numConsecutivo',
        'sap',
        'user_id',
        'motivoObjetada',
        'ObservacionesObj',
        'motivoAnulada',
        'ObservacionesAnuladas',
        'motivoTransferido',
        'ObservacionesTransferido',
    ];
  
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($instalacion) {
            DB::transaction(function () use ($instalacion) {
                // Obtiene el próximo número consecutivo
                $instalacion->numConsecutivo = Secuencia::getNextValue();
            });
        });
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Asegúrate de que el campo de la clave foránea sea correcto
    }

    public function anulacion()
    {
        return $this->belongsTo(Anulacion::class, 'motivoAnulada'); // Ajusta el campo si es necesario
    }
}