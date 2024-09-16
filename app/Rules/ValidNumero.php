<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;

class ValidNumero implements Rule
{
    /**
     * Los valores permitidos que se pueden repetir.
     *
     * @var array
     */
    protected $allowedValues = ['CLARO', 'DESPACHO', 'LEON', 'MANAGUA'];

    /**
     * Indica si la regla de validación ha pasado.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Verificar si el valor está en la lista de valores permitidos
        if (in_array($value, $this->allowedValues)) {
            return true;
        }

        // Verificar si el valor contiene solo dígitos (0-9) y tiene un máximo de 8 dígitos
        if (preg_match('/^\d{1,8}$/', $value)) {
            return true;
        }

        return false;
    }

    /**
     * Obtén el mensaje de error para la validación.
     *
     * @return string
     */
    public function message()
    {
        return 'El :attribute debe contener solo números o uno de los valores permitidos: CLARO, DESPACHO, LEON, MANAGUA.';
    }
}