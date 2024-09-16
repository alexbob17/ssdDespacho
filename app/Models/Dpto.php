<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dpto extends Model
{
    protected $table = 'dpto';
    protected $fillable = ['depto', 'colonia'];
}