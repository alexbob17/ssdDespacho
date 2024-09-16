<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Secuencia extends Model
{
    protected $table = 'secuencias'; // Asegúrate de que el nombre de la tabla es correcto

    // Agrega 'valor' a la propiedad $fillable para permitir la asignación masiva
    protected $fillable = ['valor'];

    // Método para obtener el siguiente valor de secuencia
    public static function getNextValue()
    {
        return DB::transaction(function () {
            // Bloquea la fila para evitar que otras transacciones la modifiquen simultáneamente
            $secuencia = self::lockForUpdate()->first();

            if ($secuencia) {
                $secuencia->valor += 1; // Incrementa el valor de la secuencia
                $secuencia->save();
                return $secuencia->valor;
            }

            // Si no existe la secuencia, crear una nueva con el valor por defecto
            return self::create([
                'valor' => 60000001, // Valor inicial
            ])->valor;
        });
    }
}