<?php

namespace App\Http\Controllers;

use App\Models\Tecnico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Rules\ValidNumero;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; // Asegúrate de importar esta línea


class TecnicoController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Verifica si hay un usuario autenticado
            if (!auth()->check()) {
                return redirect('/login')->with('error', 'Por favor, inicia sesión para acceder a esta página.');
            }
    
            // Verifica si el usuario autenticado tiene uno de los roles permitidos
            if (!auth()->user()->hasRole(['admin', 'supervisor n2', 'supervisor n1'])) {
                return redirect('/home')->with('error', 'No tienes permiso para acceder a esta página.');
            }
    
            return $next($request);
        });
    }
    

    // Muestra la lista de técnicos
    public function index()
    {

        
        // Verificar el rol del usuario usando Spatie
        if (!Auth::user()->hasRole(['supervisor n1', 'admin', 'supervisor n2'])) {
            return redirect('/home')->with('error', 'No tienes permiso para acceder a esta página.');
        }
    
        // Obtener todos los técnicos de la base de datos
        $tecnicos = Tecnico::all();
        
        return view('tecnicos.index', compact('tecnicos'));
    }
    
    
    public function create()
    {
        // Verificar el rol del usuario si es necesario
        if (!Auth::user()->hasRole(['admin', 'supervisor n2'])) {
            return redirect('/home')->with('error', 'No tienes permiso para realizar esta acción.');
        }
        return view('tecnicos.create');
    }

    /**
     * Validate the tecnico registration data.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre_tecnico' => ['required', 'string', 'max:255'],
            'codigo' => ['required', 'string', 'max:255', 'unique:tecnicos'],
            'numero' => ['required', 'string', 'max:20', 'unique:tecnicos'],
            'cedula' => ['nullable', 'string', 'max:20'], // Nullable
            'status' => ['required', 'in:Activo,Desactivo'],
        ]);
    }

    /**
     * Create a new tecnico instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Tecnico
     */
    protected function createTecnico(array $data)
    {
        return Tecnico::create([
            'nombre_tecnico' => $data['nombre_tecnico'],
            'codigo' => $data['codigo'],
            'numero' => $data['numero'],
            'cedula' => $data['cedula'] ?? null,
            'status' => $data['status'],
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


     public function store(Request $request)
     {
         // Verificar el rol del usuario si es necesario
         if (!Auth::user()->hasRole(['admin', 'supervisor n2'])) {
             return redirect('/home')->with('error', 'No tienes permiso para realizar esta acción.');
         }
     
         // Mensajes de error personalizados
         $messages = [
             'codigo.unique' => 'El código ya está registrado.',
             'numero.max' => 'El número no puede tener más de 8 caracteres.',
             'numero.regex' => 'El número solo puede contener letras y números.',
             'cedula.regex' => 'La cédula solo puede contener letras y números, sin espacios ni símbolos.',
             'cedula.max' => 'La cédula no puede tener más de 20 caracteres.',
             'cedula.custom' => 'La cédula ya está registrada.',
         ];
     
         // Validar los datos ingresados
         $validatedData = $request->validate([
             'nombre_tecnico' => 'required|string|max:255',
             'codigo' => [
                 'required',
                 'string',
                 'max:255',
                 'regex:/^[A-Za-z0-9]+$/',
                 'unique:tecnicos,codigo'
             ],
             'numero' => [
                 'required',
                 'string',
                 'max:8',
                 'regex:/^[A-Za-z0-9]+$/',
                 function ($attribute, $value, $fail) {
                     $allowedWords = ['CLARO', 'DESPACHO', 'LEON', 'MANAGUA', 'ACTIVO', 'MULTIPAGOS', 'INTERNO','claro','despacho','leon','managua','activo','multipagos','interno'];
                     if (!in_array($value, $allowedWords) && Tecnico::where($attribute, $value)->exists()) {
                         $fail('El número ya está registrado.');
                     }
                 }
             ],
             'cedula' => [
                 'nullable',
                 'string',
                 'max:20',
                 'regex:/^[A-Za-z0-9]+$/',
                 function ($attribute, $value, $fail) {
                     if (preg_match('/[\s\W]/', $value)) {
                         $fail('La cédula solo puede contener letras y números, sin espacios ni símbolos.');
                     }
                     if (Tecnico::where($attribute, $value)->exists()) {
                         $fail('La cédula ya está registrada.');
                     }
                 }
             ],
             'status' => 'required|in:Activo,Inactivo',
         ], $messages);
     
         // Convertir los datos a mayúsculas
         $validatedData['nombre_tecnico'] = strtoupper($validatedData['nombre_tecnico']);
         $validatedData['codigo'] = strtoupper($validatedData['codigo']);
         $validatedData['numero'] = strtoupper($validatedData['numero']);
         $validatedData['cedula'] = strtoupper($validatedData['cedula']);
     
         // Crear un nuevo técnico con los datos validados
         Tecnico::create($validatedData);
     
         // Redirigir a la lista de técnicos con un mensaje de éxito
         return redirect('/tecnicos')->with('message', 'Técnico registrado con éxito');
     }
     



    // Editar técnico
    public function edit($id)
    {
        
        $tecnico = Tecnico::findOrFail($id);
        return view('tecnicos.edit', compact('tecnico'));
    }

    // Actualizar datos del técnico
    public function update(Request $request, $id)
    {
        // Buscar el técnico por ID
        $tecnico = Tecnico::findOrFail($id);
    
        // Mensajes personalizados para las validaciones
        $messages = [
            'codigo.unique' => 'El código ya está registrado.',
            'numero.max' => 'El número no puede tener más de 8 caracteres.',
            'numero.regex' => 'El número solo puede contener letras y números.',
            'cedula.regex' => 'La cédula solo puede contener letras y números, sin espacios ni símbolos.',
            'cedula.max' => 'La cédula no puede tener más de 20 caracteres.',
            'cedula.custom' => 'La cédula ya está registrada.',
        ];
    
        // Validar los datos ingresados
        $validatedData = $request->validate([
            'nombre_tecnico' => 'required|string|max:255',
            'codigo' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9]+$/',
                Rule::unique('tecnicos', 'codigo')->ignore($tecnico->id),
            ],
            'numero' => [
                'required',
                'string',
                'max:8',
                'regex:/^[A-Za-z0-9]+$/',
                function ($attribute, $value, $fail) use ($tecnico) {
                    $allowedWords = ['CLARO', 'DESPACHO', 'LEON', 'MANAGUA', 'ACTIVO', 'MULTIPAGOS', 'INTERNO','claro','despacho','leon','managua','activo','multipagos','interno'];
                    if (!in_array($value, $allowedWords) && Tecnico::where($attribute, $value)->where('id', '!=', $tecnico->id)->exists()) {
                        $fail('El número ya está registrado.');
                    }
                }
            ],
            'cedula' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[A-Za-z0-9]+$/',
                function ($attribute, $value, $fail) use ($tecnico) {
                    if (preg_match('/[\s\W]/', $value)) {
                        $fail('La cédula solo puede contener letras y números, sin espacios ni símbolos.');
                    }
                    if (Tecnico::where($attribute, $value)->where('id', '!=', $tecnico->id)->exists()) {
                        $fail('La cédula ya está registrada.');
                    }
                }
            ],
            'status' => 'required|in:Activo,Inactivo',
        ], $messages);
    
        // Actualizar los datos del técnico con los datos validados
        $tecnico->update($validatedData);
    
        // Redirigir a la lista de técnicos con un mensaje de éxito
        return redirect('/tecnicos')->with('message', 'Técnico actualizado con éxito');
    }


    public function destroy(Tecnico $tecnico)
    {

        // Verificar el rol del usuario si es necesario
        if (!Auth::user()->hasRole(['admin', 'supervisor n2'])) {
            return redirect('/home')->with('error', 'No tienes permiso para realizar esta acción.');
        }
        // Eliminar el técnico
        $tecnico->forceDelete(); // Elimina el registro físicamente

        // Retornar una respuesta JSON indicando éxito
        return response()->json(['success' => true]);
    }


}