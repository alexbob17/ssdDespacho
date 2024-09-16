<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Verificar si el usuario tiene uno de los roles permitidos
        if (!Auth::user()->hasRole(['admin', 'supervisor n2', 'supervisor n1'])) {
            return redirect('/home')->with('error', 'No tienes permiso para acceder a esta página.');
        }

        $users = User::all();

        $users->load('roles', 'permissions');

        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        if (!Auth::check() || !Auth::user()->hasRole(['supervisor n1', 'admin', 'supervisor n2'])) {
            return redirect('/home')->with('error', 'No tienes permiso para acceder a esta página.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::user()->hasRole(['admin', 'supervisor n2'])) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción.'], 403);
        }

        // Mensajes de validación personalizados
        $messages = [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas deben coincidir.',
            'role.required' => 'El rol es obligatorio.',
            'role.in' => 'El rol seleccionado no es válido.',
            'password_confirmation.same' => 'Las contraseñas deben coincidir.',
        ];

        // Validar los datos ingresados
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $user->id, // Asegúrate de que el email sea único excepto para el usuario actual
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed', // Validar que las contraseñas coincidan
            ],
            'password_confirmation' => 'nullable|same:password',
            'role' => 'required|string|in:admin,supervisor n1,supervisor n2,operador n1,operador n2',
        ], $messages);

        // Verificar si hay errores de validación
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);  // Devuelve los errores en formato JSON
        }

        // Actualizar los campos básicos
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Actualizar la contraseña si se proporciona
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Primero eliminamos todos los roles actuales del usuario
        $user->syncRoles([]); 

        // Luego asignamos el nuevo rol
        $user->assignRole($request->input('role'));

        $user->save();

        // Si el usuario actual es el usuario que se está actualizando,
        // volver a iniciar la sesión para mantener al usuario logueado
        if (auth()->user()->id == $user->id) {
            auth()->login($user);
        }

        // Responder con un mensaje de éxito
        return response()->json(['success' => true, 'message' => 'Usuario actualizado con éxito']);
    }

    


    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => true]);
    }

    public function resetPassword($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->password = bcrypt('12345678');
            $user->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}