<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Secuencia;


class Reparacion extends Model
{
    use HasFactory;

    protected $table = 'reparaciones'; // 


    protected $fillable = [
        'codigo', 'numero', 'nombre_tecnico', 'tipoOrden', 'tipoactividad', 'Depto', 'codigocausa', 'tipocausa',
        'tipodaño', 'ubicaciondaño', 'orden', 'solicitudcambio', 'recibe', 'comentarios', 'motivoObjetada',
        'comentariosObjetado', 'ObservacionesTransferida', 'comentariosTransferida', 'status', 'user_id', 'numConsecutivo'
    ];

    // Relación con el usuario
    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($reparacion) {
            DB::transaction(function () use ($reparacion) {
                // Obtiene el próximo número consecutivo
                $reparacion->numConsecutivo = Secuencia::getNextValue();
            });
        });
    }
    
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Asegúrate de que el campo de la clave foránea sea correcto
    }


    public function dpto()
    {
        return $this->belongsTo(Dpto::class, 'depto');  // Suponiendo que 'depto' es la columna de clave foránea
    }
    
}