<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tecnico extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre_tecnico',
        'codigo',
        'numero',
        'cedula',
        'status',
    ];

    public function setNumeroAttribute($value)
    {
        $this->attributes['numero'] = strtoupper($value);
    }

    public function setCodigoAttribute($value)
    {
        $this->attributes['codigo'] = strtoupper($value);
    }
}