<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    // Mostrar el formulario de cambio de contraseña
    public function showChangePasswordForm()
    {
        return view('users.passwordchange');
    }

    

    public function changePassword(Request $request)
    {
        // Definir mensajes de error personalizados
        $messages = [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'new_password.required' => 'La nueva contraseña es obligatoria.',
            'new_password.string' => 'La nueva contraseña debe ser una cadena de texto.',
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'new_password.confirmed' => 'Las contraseñas nuevas deben coincidir.',
            'new_password.different' => 'La nueva contraseña no puede ser igual a la contraseña actual.',
        ];
    
        // Validar los datos del request
        $validator = Validator::make($request->all(), [
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Verifica si la contraseña actual ingresada coincide con la contraseña almacenada
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('La contraseña actual es incorrecta.');
                    }
                },
            ],
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'different:current_password',
            ],
        ], $messages);
    
        // Si la validación falla, retornar los errores
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Actualizar la contraseña del usuario
        $user = Auth::user();
        $user->password = Hash::make($request->input('new_password'));
        $user->save();
    
        // Retornar una respuesta de éxito
        return response()->json(['message' => 'Contraseña actualizada con éxito.']);
    }




    // Procesar el reseteo de contraseña a un valor predeterminado
    public function resetPassword()
    {
        $user = Auth::user();

        // Reseteo de la contraseña a '12345678'
        $user->password = Hash::make('12345678');
        $user->save();

        return redirect()->route('profile.change-password')->with('message', 'Contraseña reseteada a 12345678.');
    }
}