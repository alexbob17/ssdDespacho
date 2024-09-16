<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anulacion extends Model
{
    use HasFactory;

    // Especificar la tabla asociada
    protected $table = 'anulaciones';

    // Los campos que se pueden asignar masivamente
    protected $fillable = ['MotivoAnulacion'];


    public function setMotivoAnulacionAttribute($value)
    {
        $this->attributes['MotivoAnulacion'] = strtoupper($value);
    }

    
}