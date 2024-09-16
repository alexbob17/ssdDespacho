<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditarConsulta extends Model
{
    use HasFactory;

       // Define el nombre de la tabla si es diferente del nombre plural del modelo
       protected $table = 'editarconsultas';

       // Define los campos que se pueden llenar de forma masiva
       protected $fillable = ['MotivoConsulta'];

}