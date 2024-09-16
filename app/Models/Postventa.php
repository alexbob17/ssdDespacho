<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Secuencia;


class Postventa extends Model
{
    use HasFactory;

    protected $table = 'postventas'; // 


    protected $fillable = [
        'codigo',
        'numero',
        'nombre_tecnico',
        'tipoOrden',
        'tipoactividad',
        'depto',
        'orden',
        'observaciones',
        'recibe',
        'nodo',
        'tap_caja',
        'posicion_puerto',
        'materiales',
        'equipotv1',
        'equipotv2',
        'equipotv3',
        'equipotv4',
        'equipotv5',
        'equipotvretira1',
        'equipotvretira2',
        'equipotvretira3',
        'equipotvretira4',
        'equipotvretira5',
        'equipomodem',
        'equipomodemret',
        'coordenadas',
        'numerocobre',
        'motivoAnulada',
        'ObservacionesAnuladas',
        'motivoObjetada',
        'ObservacionesObj',
        'motivoTransferido',
        'status',
        'user_id',
        'numConsecutivo',
    ];

    // Relación con el modelo User (si es necesario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($postventa) {
            DB::transaction(function () use ($postventa) {
                // Obtiene el próximo número consecutivo
                $postventa->numConsecutivo = Secuencia::getNextValue();
            });
        });
    }

    public function anulacion()
    {
        return $this->belongsTo(Anulacion::class, 'motivoAnulada'); // Ajusta el campo si es necesario
    }
}