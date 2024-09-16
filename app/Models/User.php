<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    // En el archivo app/Models/User.php

public function agendamientos()
{
    return $this->hasMany(Agendamiento::class, 'usuario_id'); // Asegúrate de que el campo de la clave foránea sea correcto
}

public function instalaciones()
{
    return $this->hasMany(Instalaciones::class, 'user_id'); // Asegúrate de que el campo de la clave foránea sea correcto
}

public function reparaciones()
{
    return $this->hasMany(Reparacion::class, 'user_id'); // Asegúrate de que el campo de la clave foránea sea correcto
}

public function postventa()
{
    return $this->hasMany(Postventa::class, 'user_id'); // Asegúrate de que el campo de la clave foránea sea correcto
}

public function consultas()
{
    return $this->hasMany(Consulta::class, 'user_id'); // Asegúrate de que el campo de la clave foránea sea correcto
}

}