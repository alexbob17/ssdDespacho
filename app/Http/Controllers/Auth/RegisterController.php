<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); // Asegura que el usuario esté autenticado

        $this->middleware(function ($request, $next) {
            // Verifica el rol del usuario usando Spatie
            if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('supervisor n2')) {
                return redirect('/home')->with('message', 'No tienes permiso para acceder a esta página.');
            }
            return $next($request);
        });
    }



    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:admin,supervisor n1,supervisor n2,operador n1,operador n2'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'], // Asigna el rol proporcionado
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    

     public function register(Request $request)
    {
        if (!Auth::user()->hasRole(['admin', 'supervisor n2'])) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción.'], 403);
        }

        // Mensajes de validación personalizados
        $messages = [
            'name.required' => 'El nombre es obligatorio.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
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
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
            ],
            'password_confirmation' => 'required|same:password',
            'role' => 'required|string|in:admin,supervisor n1,supervisor n2,operador n1,operador n2',
        ], $messages);

        // Verificar si hay errores de validación
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);  // Devuelve los errores en formato JSON
        }

        // Crear usuario y asignar rol
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user->assignRole($request->input('role'));

        // Responder con un mensaje de éxito
        return response()->json(['success' => true, 'message' => 'Usuario registrado con éxito']);
    }



    

}