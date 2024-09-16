<?php

// app/Http/Controllers/InstalacionController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dpto;
use App\Models\Instalaciones;
use App\Models\Anulacion;
use Carbon\Carbon;
use App\Models\Tecnico; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class InstalacionController extends Controller
{
    // Método para mostrar el formulario de creación de instalaciones
    public function index()
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            // Redirigir al usuario al login si no está autenticado
            return redirect()->route('login');
        }

        $dptos = Dpto::all();
        $anulacion = Anulacion::all();

        
        // Pasa los datos a la vista
        return view('instalaciones.index', compact('dptos'), compact('anulacion'));
    }


    public function getTecnico(Request $request, $codigo)
    {
        // Buscar al técnico por su código
        $tecnico = Tecnico::where('codigo', $codigo)->first();

        // Verificar si el técnico existe
        if ($tecnico) {
            // Verificar si el estado del técnico es "Activo"
            if ($tecnico->status === "Activo") {
                // Devolver una respuesta de éxito si el técnico está activo
                return response()->json([
                    'success' => true,
                    'message' => 'Técnico encontrado y está activo',
                    'tecnico' => [
                        'numero' => $tecnico->numero,
                        'nombre_tecnico' => $tecnico->nombre_tecnico
                    ]
                ]);
            } else {
                // Devolver una respuesta de error si el técnico no está activo
                return response()->json([
                    'success' => false,
                    'message' => 'Técnico no está activo',
                ]);
            }
        } else {
            // Devolver una respuesta de error si el técnico no fue encontrado
            return response()->json([
                'success' => false,
                'message' => 'Técnico no encontrado',
            ]);
        }
    }



    
    public function store(Request $request)
    {
        // Definir reglas básicas comunes
        $rules = [
            'codigo' => 'required|string',
            'numero' => 'required|string',
            'nombre_tecnico' => 'required|string',
            'depto' => 'required|string',
            'tipoactividad' => 'required|string',
            'tipoOrden' => 'required|string',
            'status' => 'nullable|string', // Agregar `status` como opcional
        ];

        // Definir mensajes de error personalizados
        $messages = [
            'required' => ':attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser una cadena de texto.',
            'exists' => 'El usuario seleccionado no es válido.',
            'size' => 'Debe tener :size dígitos.',
        ];

        // Validar los datos iniciales
        $validatedData = $request->validate($rules, $messages);

        // Obtener los valores de las órdenes del request
        $ordenTv = $request->input('ordenTv');
        $ordenInternet = $request->input('ordenInternet');
        $ordenLinea = $request->input('ordenLinea');

        // Verificar si el número de orden ya existe en alguna de las columnas con estado 'Pendiente'
        $exists = Instalaciones::where('status', 'Pendiente')
            ->where(function ($query) use ($ordenTv, $ordenInternet, $ordenLinea) {
                // Verificar solo los campos que no están vacíos
                if (!empty($ordenTv)) {
                    $query->orWhere('ordenTv', $ordenTv)
                        ->orWhere('ordenInternet', $ordenTv)
                        ->orWhere('ordenLinea', $ordenTv);
                }
                if (!empty($ordenInternet)) {
                    $query->orWhere('ordenTv', $ordenInternet)
                        ->orWhere('ordenInternet', $ordenInternet)
                        ->orWhere('ordenLinea', $ordenInternet);
                }
                if (!empty($ordenLinea)) {
                    $query->orWhere('ordenTv', $ordenLinea)
                        ->orWhere('ordenInternet', $ordenLinea)
                        ->orWhere('ordenLinea', $ordenLinea);
                }
            })
            ->exists();

        // Si existe un registro que coincide, retornar el error
        if ($exists) {
            return response()->json([
                'errormsg' => "Boleta pendiente, Orden ya registrada.",
            ], 400); // Cambia a 400 para Bad Request
        }

        // Agregar reglas adicionales según el tipo de actividad
        $additionalRules = [];
        switch ($validatedData['tipoactividad']) {
            case 'Realizada':
                $additionalRules = $this->getAdditionalRules($validatedData['tipoOrden']);
                break;
            case 'Objetada':
                $additionalRules = $this->getAdditionalRulesObj($validatedData['tipoOrden']);
                break;
            case 'Anulacion':
                $additionalRules = $this->getAdditionalRulesAnul($validatedData['tipoOrden']);
                break;
            case 'Transferida':
                $additionalRules = $this->getAdditionalRulesTransf($validatedData['tipoOrden']);
                break;
            default:
                return response()->json([
                    'errors' => ['Tipo de actividad no reconocido.']
                ]);
        }

        // Validar nuevamente con todas las reglas
        $rules = array_merge($rules, $additionalRules);
        $validatedData = $request->validate($rules, $messages);

        // Asignar `status` y `user_id` al registro
        $validatedData['status'] = $request->input('status', 'Pendiente');
        $validatedData['user_id'] = auth()->id();

        // Crear el registro en la tabla de instalaciones
        $instalacion = Instalaciones::create($validatedData);

        // Obtener el numConsecutivo generado
        $numConsecutivo = $instalacion->numConsecutivo;

        // Retornar una respuesta JSON con el mensaje de éxito
        return response()->json([
            'redirect_url' => route('instalaciones.index'),
            'message' => "Registro guardado ☑️\n <h3>Boleta #$numConsecutivo </h3>",
            'numConsecutivo' => $numConsecutivo,
        ]);
    }

    public function update(Request $request, $id)
    {
        //Log::info('Datos del request:', $request->all());

        $rules = [
            'codigo' => 'required|string',
            'numero' => 'required|string',
            'nombre_tecnico' => 'required|string',
            'depto' => 'required|string',
            'tipoactividad' => 'required|string',
            'tipoOrden' => 'required|string',
            'status' => 'nullable|string', // Agregar `status` como opcional
        ];

        // Definir mensajes de error personalizados
        $messages = [
            'required' => ':attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser una cadena de texto.',
            'exists' => 'El usuario seleccionado no es válido.',
            'size' => 'Debe tener :size dígitos.',
        ];

        // Validar los datos iniciales
        $validatedData = $request->validate($rules, $messages);

        // Obtener los valores de las órdenes del request
        $ordenTv = $request->input('ordenTv');
        $ordenInternet = $request->input('ordenInternet');
        $ordenLinea = $request->input('ordenLinea');

        $exists = Instalaciones::where('status', 'Pendiente')
            ->where('id', '!=', $id) // Excluir el registro actual
            ->where(function ($query) use ($ordenTv, $ordenInternet, $ordenLinea) {
                // Verificar solo los campos que no están vacíos
                if (!empty($ordenTv)) {
                    $query->orWhere('ordenTv', $ordenTv)
                        ->orWhere('ordenInternet', $ordenTv)
                        ->orWhere('ordenLinea', $ordenTv);
                }
                if (!empty($ordenInternet)) {
                    $query->orWhere('ordenTv', $ordenInternet)
                        ->orWhere('ordenInternet', $ordenInternet)
                        ->orWhere('ordenLinea', $ordenInternet);
                }
                if (!empty($ordenLinea)) {
                    $query->orWhere('ordenTv', $ordenLinea)
                        ->orWhere('ordenInternet', $ordenLinea)
                        ->orWhere('ordenLinea', $ordenLinea);
                }
            })
            ->exists();

        if ($exists) {
            return response()->json([
                'errormsg' => "Boleta Pendiente",
            ], 400); // Cambia a 400 para Bad Request
        }

        $additionalRules = [];
        switch ($validatedData['tipoactividad']) {
            case 'Realizada':
                $additionalRules = $this->getAdditionalRules($validatedData['tipoOrden']);
                break;
            case 'Objetada':
                $additionalRules = $this->getAdditionalRulesObj($validatedData['tipoOrden']);
                break;
            case 'Anulacion':
                $additionalRules = $this->getAdditionalRulesAnul($validatedData['tipoOrden']);
                break;
            case 'Transferida':
                $additionalRules = $this->getAdditionalRulesTransf($validatedData['tipoOrden']);
                break;
            default:
                return response()->json([
                    'errors' => ['Tipo de actividad no reconocido.']
                ]);
        }

        $rules = array_merge($rules, $additionalRules);
        $validatedData = $request->validate($rules, $messages);

        $instalacion = Instalaciones::findOrFail($id);
        $instalacion->update($validatedData);

        // Asignar el status y mantener el `user_id` original
        $instalacion->status = $request->input('status', 'Pendiente');
        $instalacion->save();

        // Retornar una respuesta JSON con el mensaje de éxito
        return response()->json([
            'redirect_url' => route('busqueda.index'),
            'message' => "Boleta Actualizada ☑️",
        ]);
    }

    
    protected function getAdditionalRules($tipoOrden)
    {
        $rules = [];
    
        switch ($tipoOrden) {
            case 'TRIPLE INSTALACION HFC':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'ordenLinea' => 'required|size:8',
                    'equiposTvnumero1' => 'required|string',
                    'equiposTvnumero2' => 'nullable|string',
                    'equiposTvnumero3' => 'nullable|string',
                    'equiposTvnumero4' => 'nullable|string',
                    'equiposTvnumero5' => 'nullable|string',
                    'equipoModem' => 'required|string',
                    'coordenadas' => 'required|string',
                    'observaciones' => 'required|string',
                    'numeroLinea' => 'required|string',
                    'recibe' => 'required|string',
                    'nodo' => 'required|string',
                    'tapCaja' => 'required|string',
                    'posicion' => 'required|string',
                    'materiales' => 'required|string',
                    'sap' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION TV + INTERNET HFC':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'equiposTvnumero1' => 'required|string',
                    'equiposTvnumero2' => 'nullable|string',
                    'equiposTvnumero3' => 'nullable|string',
                    'equiposTvnumero4' => 'nullable|string',
                    'equiposTvnumero5' => 'nullable|string',
                    'equipoModem' => 'required|string',
                    'coordenadas' => 'required|string',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                    'nodo' => 'required|string',
                    'tapCaja' => 'required|string',
                    'posicion' => 'required|string',
                    'materiales' => 'required|string',
                    'sap' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION INTERNET + LINEA HFC':
                $rules = [
                    'ordenInternet' => 'required|size:8',
                    'ordenLinea' => 'required|size:8',
                    'numeroLinea' => 'required|string',
                    'equipoModem' => 'required|string',
                    'coordenadas' => 'required|string',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                    'nodo' => 'required|string',
                    'tapCaja' => 'required|string',
                    'posicion' => 'required|string',
                    'materiales' => 'required|string',
                    'sap' => 'required|string',
                ];
                break;
            case 'INDIVIDUAL ANALOGO HFC':
                $rules = [
                        'ordenTv' => 'required|size:8',
                        'coordenadas' => 'required|string',
                        'observaciones' => 'required|string',
                        'recibe' => 'required|string',
                        'nodo' => 'required|string',
                        'tapCaja' => 'required|string',
                        'posicion' => 'required|string',
                        'materiales' => 'required|string',
                        'sap' => 'required|string',
                    ];
                break;
            case 'INDIVIDUAL DIGITAL TV HFC':
                $rules = [
                        'required|size:8',
                        'equiposTvnumero1' => 'required|string',
                        'equiposTvnumero2' => 'nullable|string',
                        'equiposTvnumero3' => 'nullable|string',
                        'equiposTvnumero4' => 'nullable|string',
                        'equiposTvnumero5' => 'nullable|string',
                        'coordenadas' => 'required|string',
                        'observaciones' => 'required|string',
                        'recibe' => 'required|string',
                        'nodo' => 'required|string',
                        'tapCaja' => 'required|string',
                        'posicion' => 'required|string',
                        'materiales' => 'required|string',
                        'sap' => 'required|string',
                    ];
                break;
            case 'INDIVIDUAL INTERNET HFC':
                $rules = [
                        'ordenInternet' => 'required|size:8',
                        'equipoModem' => 'required|string',
                        'coordenadas' => 'required|string',
                        'observaciones' => 'required|string',
                        'recibe' => 'required|string',
                        'nodo' => 'required|string',
                        'tapCaja' => 'required|string',
                        'posicion' => 'required|string',
                        'materiales' => 'required|string',
                        'sap' => 'required|string',
                    ];
                break;
            case 'INDIVIDUAL LINEA HFC':
                $rules = [
                        'ordenLinea' => 'required|size:8',
                        'numeroLinea' => 'required|string',
                        'equipoModem' => 'required|string',
                        'coordenadas' => 'required|string',
                        'observaciones' => 'required|string',
                        'recibe' => 'required|string',
                        'nodo' => 'required|string',
                        'tapCaja' => 'required|string',
                        'posicion' => 'required|string',
                        'materiales' => 'required|string',
                        'sap' => 'required|string',
                    ];
                break;
            case 'TRIPLE INSTALACION GPON':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'ordenLinea' => 'required|size:8',
                    'equiposTvnumero1' => 'required|string',
                    'equiposTvnumero2' => 'nullable|string',
                    'equiposTvnumero3' => 'nullable|string',
                    'equiposTvnumero4' => 'nullable|string',
                    'equiposTvnumero5' => 'nullable|string',
                    'equipoModem' => 'required|string',
                    'coordenadas' => 'required|string',
                    'observaciones' => 'required|string',
                    'numeroLinea' => 'required|string',
                    'recibe' => 'required|string',
                    'nodo' => 'required|string',
                    'tapCaja' => 'required|string',
                    'posicion' => 'required|string',
                    'materiales' => 'required|string',
                    'sap' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION IPTV + LINEA GPON':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenLinea' => 'required|size:8',
                    'equiposTvnumero1' => 'required|string',
                    'equiposTvnumero2' => 'nullable|string',
                    'equiposTvnumero3' => 'nullable|string',
                    'equiposTvnumero4' => 'nullable|string',
                    'equiposTvnumero5' => 'nullable|string',
                    'observaciones' => 'required|string',
                    'numeroLinea' => 'required|string',
                    'recibe' => 'required|string',
                    'sap' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION INTERNET + IPTV GPON':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'equiposTvnumero1' => 'required|string',
                    'equiposTvnumero2' => 'nullable|string',
                    'equiposTvnumero3' => 'nullable|string',
                    'equiposTvnumero4' => 'nullable|string',
                    'equiposTvnumero5' => 'nullable|string',
                    'observaciones' => 'required|string',
                    'equipoModem' => 'required|string',
                    'recibe' => 'required|string',
                    'nodo' => 'required|string',
                    'tapCaja' => 'required|string',
                    'posicion' => 'required|string',
                    'materiales' => 'required|string',
                    'sap' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION INTERNET + LINEA GPON':
                $rules = [
                    'ordenLinea' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'numeroLinea' => 'required|string',
                    'observaciones' => 'required|string',
                    'equipoModem' => 'required|string',
                    'recibe' => 'required|string',
                    'nodo' => 'required|string',
                    'tapCaja' => 'required|string',
                    'posicion' => 'required|string',
                    'materiales' => 'required|string',
                    'sap' => 'required|string',
                ];
                break;
            case 'INDIVIDUAL INTERNET GPON':
                $rules = [
                    'ordenInternet' => 'required|size:8',
                    'observaciones' => 'required|string',
                    'equipoModem' => 'required|string',
                    'recibe' => 'required|string',
                    'nodo' => 'required|string',
                    'tapCaja' => 'required|string',
                    'posicion' => 'required|string',
                    'materiales' => 'required|string',
                    'sap' => 'required|string',
                ];
                break;
            case 'INDIVIDUAL IPTV GPON':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'equiposTvnumero1' => 'required|string',
                    'equiposTvnumero2' => 'nullable|string',
                    'equiposTvnumero3' => 'nullable|string',
                    'equiposTvnumero4' => 'nullable|string',
                    'equiposTvnumero5' => 'nullable|string',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                    'sap' => 'required|string',
                ];
                break;
            case 'INDIVIDUAL LINEA GPON':
                $rules = [
                    'ordenLinea' =>'required|size:8',
                    'equipoModem' => 'required|string',
                    'numeroLinea' => 'required|string',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                    'sap' => 'required|string',
                ];
                break;
            case 'INSTALACION INTERNET ADSL':
                $rules = [
                    'ordenInternet' => 'required|size:8',
                    'equipoModem' => 'required|string',
                    'coordenadas' => 'required|string',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                ];
                break;
            case 'INSTALACION LINEA COBRE':
                $rules = [
                    'ordenLinea' => 'required|size:8',
                    'coordenadas' => 'required|string',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                    'sap' => 'required|string',
                ];
                break;
            case 'INSTALACION TV SATELITAL DTH':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'equiposTvnumero1' => 'required|string',
                    'equiposTvnumero2' => 'nullable|string',
                    'equiposTvnumero3' => 'nullable|string',
                    'equiposTvnumero4' => 'nullable|string',
                    'equiposTvnumero5' => 'nullable|string',
                    'smartcardnumero1' => 'required|string',
                    'smartcardnumero2' => 'nullable|string',
                    'smartcardnumero3' => 'nullable|string',
                    'smartcardnumero4' => 'nullable|string',
                    'smartcardnumero5' => 'nullable|string',
                    'coordenadas' => 'required|string',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                    'sap' => 'required|string',
                ];
                break;
            // Otros casos pueden ser añadidos aquí según sea necesario
        }
        return $rules;
    }
    
    protected function getAdditionalRulesObj($tipoOrden)
    {
        $rules = [];
    
        switch ($tipoOrden) {
            case 'TRIPLE INSTALACION HFC':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'ordenLinea' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION TV + INTERNET HFC':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION INTERNET + LINEA HFC':
                $rules = [
                    'ordenInternet' => 'required|size:8',
                    'ordenLinea' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'INDIVIDUAL ANALOGO HFC':
                $rules = [
                        'ordenTv' => 'required|size:8',
                        'motivoObjetada' => 'required|string',
                        'ObservacionesObj' => 'required|string',
                    ];
                break;
            case 'INDIVIDUAL DIGITAL TV HFC':
                $rules = [
                        'ordenTv' => 'required|size:8',
                        'motivoObjetada' => 'required|string',
                        'ObservacionesObj' => 'required|string',
                    ];
                break;
            case 'INDIVIDUAL INTERNET HFC':
                $rules = [
                        'ordenInternet' => 'required|size:8',
                        'motivoObjetada' => 'required|string',
                        'ObservacionesObj' => 'required|string',
                    ];
                break;
            case 'INDIVIDUAL LINEA HFC':
                $rules = [
                        'ordenLinea' => 'required|size:8',
                        'motivoObjetada' => 'required|string',
                        'ObservacionesObj' => 'required|string',
                    ];
                break;
            case 'TRIPLE INSTALACION GPON':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'ordenLinea' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION IPTV + LINEA GPON':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenLinea' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION INTERNET + IPTV GPON':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION INTERNET + LINEA GPON':
                $rules = [
                    'ordenLinea' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'INDIVIDUAL INTERNET GPON':
                $rules = [
                    'ordenInternet' => 'required|size:8',
                    'observaciones' => 'required|string',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'INDIVIDUAL IPTV GPON':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'INDIVIDUAL LINEA GPON':
                $rules = [
                    'ordenLinea' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'INSTALACION INTERNET ADSL':
                $rules = [
                    'ordenInternet' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'INSTALACION LINEA COBRE':
                $rules = [
                    'ordenLinea' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'INSTALACION TV SATELITAL DTH':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            // Otros casos pueden ser añadidos aquí según sea necesario
        }
        return $rules;
    }

    protected function getAdditionalRulesAnul($tipoOrden)
    {
        $rules = [];
    
        switch ($tipoOrden) {
            case 'TRIPLE INSTALACION HFC':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'ordenLinea' => 'required|size:8',
                    'motivoAnulada' => 'required|string',
                    'ObservacionesAnuladas' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION TV + INTERNET HFC':
                $rules = [
                    'ordenTv' => +'required|size:8',
                    'ordenInternet' => +'required|size:8',
                    'motivoAnulada' => 'required|string',
                    'ObservacionesAnuladas' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION INTERNET + LINEA HFC':
                $rules = [
                    'ordenInternet' => 'required|size:8',
                    'ordenLinea' => 'required|size:8',
                    'motivoAnulada' => 'required|string',
                    'ObservacionesAnuladas' => 'required|string',
                ];
                break;
            case 'INDIVIDUAL ANALOGO HFC':
                $rules = [
                        'ordenTv' => 'required|size:8',
                        'motivoAnulada' => 'required|string',
                        'ObservacionesAnuladas' => 'required|string',
                    ];
                break;
            case 'INDIVIDUAL DIGITAL TV HFC':
                $rules = [
                        'ordenTv' => 'required|size:8',
                        'motivoAnulada' => 'required|string',
                        'ObservacionesAnuladas' => 'required|string',
                    ];
                break;
            case 'INDIVIDUAL INTERNET HFC':
                $rules = [
                        'ordenInternet' => 'required|size:8',
                        'motivoAnulada' => 'required|string',
                        'ObservacionesAnuladas' => 'required|string',
                    ];
                break;
            case 'INDIVIDUAL LINEA HFC':
                $rules = [
                        'ordenLinea' =>'required|size:8',
                        'motivoAnulada' => 'required|string',
                        'ObservacionesAnuladas' => 'required|string',
                    ];
                break;
            case 'TRIPLE INSTALACION GPON':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'ordenLinea' => 'required|size:8',
                    'motivoAnulada' => 'required|string',
                    'ObservacionesAnuladas' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION IPTV + LINEA GPON':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenLinea' => 'required|size:8',
                    'motivoAnulada' => 'required|string',
                    'ObservacionesAnuladas' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION INTERNET + IPTV GPON':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'motivoAnulada' => 'required|string',
                    'ObservacionesAnuladas' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION INTERNET + LINEA GPON':
                $rules = [
                    'ordenLinea' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'motivoAnulada' => 'required|string',
                    'ObservacionesAnuladas' => 'required|string',
                ];
                break;
            case 'INDIVIDUAL INTERNET GPON':
                $rules = [
                    'ordenInternet' => 'required|size:8',
                    'observaciones' => 'required|string',
                    'motivoAnulada' => 'required|string',
                    'ObservacionesAnuladas' => 'required|string',
                ];
                break;
            case 'INDIVIDUAL IPTV GPON':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'motivoAnulada' => 'required|string',
                    'ObservacionesAnuladas' => 'required|string',
                ];
                break;
            case 'INDIVIDUAL LINEA GPON':
                $rules = [
                    'ordenLinea' => 'required|size:8',
                    'motivoAnulada' => 'required|string',
                    'ObservacionesAnuladas' => 'required|string',
                ];
                break;
            case 'INSTALACION INTERNET ADSL':
                $rules = [
                    'ordenInternet' => 'required|size:8',
                    'motivoAnulada' => 'required|string',
                    'ObservacionesAnuladas' => 'required|string',
                ];
                break;
            case 'INSTALACION LINEA COBRE':
                $rules = [
                    'ordenLinea' => 'required|size:8',
                    'motivoAnulada' => 'required|string',
                    'ObservacionesAnuladas' => 'required|string',
                ];
                break;
            case 'INSTALACION TV SATELITAL DTH':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'motivoAnulada' => 'required|string',
                    'ObservacionesAnuladas' => 'required|string',
                ];
                break;
            // Otros casos pueden ser añadidos aquí según sea necesario
        }
        return $rules;
    }
    
    protected function getAdditionalRulesTransf($tipoOrden)
    {
        $rules = [];
    
        switch ($tipoOrden) {
            case 'TRIPLE INSTALACION HFC':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'ordenLinea' => 'required|size:8',
                    'motivoTransferido' => 'required|string',
                    'ObservacionesTransferido' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION TV + INTERNET HFC':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'motivoTransferido' => 'required|string',
                    'ObservacionesTransferido' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION INTERNET + LINEA HFC':
                $rules = [
                    'ordenInternet' => 'required|size:8',
                    'ordenLinea' => 'required|size:8',
                    'motivoTransferido' => 'required|string',
                    'ObservacionesTransferido' => 'required|string',
                ];
                break;
            case 'INDIVIDUAL ANALOGO HFC':
                $rules = [
                        'ordenTv' => 'required|size:8',
                        'motivoTransferido' => 'required|string',
                        'ObservacionesTransferido' => 'required|string',
                    ];
                break;
            case 'INDIVIDUAL DIGITAL TV HFC':
                $rules = [
                        'ordenTv' => 'required|size:8',
                        'motivoTransferido' => 'required|string',
                        'ObservacionesTransferido' => 'required|string',
                    ];
                break;
            case 'INDIVIDUAL INTERNET HFC':
                $rules = [
                        'ordenInternet' => 'required|size:8',
                        'motivoTransferido' => 'required|string',
                        'ObservacionesTransferido' => 'required|string',
                    ];
                break;
            case 'INDIVIDUAL LINEA HFC':
                $rules = [
                        'ordenLinea' => 'required|size:8',
                        'motivoTransferido' => 'required|string',
                        'ObservacionesTransferido' => 'required|string',
                    ];
                break;
            case 'TRIPLE INSTALACION GPON':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'ordenLinea' => 'required|size:8',
                    'motivoTransferido' => 'required|string',
                    'ObservacionesTransferido' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION IPTV + LINEA GPON':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenLinea' => 'required|size:8',
                    'motivoTransferido' => 'required|string',
                    'ObservacionesTransferido' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION INTERNET + IPTV GPON':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'motivoTransferido' => 'required|string',
                    'ObservacionesTransferido' => 'required|string',
                ];
                break;
            case 'DOBLE INSTALACION INTERNET + LINEA GPON':
                $rules = [
                    'ordenLinea' => 'required|size:8',
                    'ordenInternet' => 'required|size:8',
                    'motivoTransferido' => 'required|string',
                    'ObservacionesTransferido' => 'required|string',
                ];
                break;
            case 'INDIVIDUAL INTERNET GPON':
                $rules = [
                    'ordenInternet' => 'required|size:8',
                    'observaciones' => 'required|string',
                    'motivoTransferido' => 'required|string',
                    'ObservacionesTransferido' => 'required|string',
                ];
                break;
            case 'INDIVIDUAL IPTV GPON':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'motivoTransferido' => 'required|string',
                    'ObservacionesTransferido' => 'required|string',
                ];
                break;
            case 'INDIVIDUAL LINEA GPON':
                $rules = [
                    'ordenLinea' => 'required|size:8',
                    'motivoTransferido' => 'required|string',
                    'ObservacionesTransferido' => 'required|string',
                ];
                break;
            case 'INSTALACION INTERNET ADSL':
                $rules = [
                    'ordenInternet' => 'required|size:8',
                    'motivoTransferido' => 'required|string',
                    'ObservacionesTransferido' => 'required|string',
                ];
                break;
            case 'INSTALACION LINEA COBRE':
                $rules = [
                    'ordenLinea' => 'required|size:8',
                    'motivoTransferido' => 'required|string',
                    'ObservacionesTransferido' => 'required|string',
                ];
                break;
            case 'INSTALACION TV SATELITAL DTH':
                $rules = [
                    'ordenTv' => 'required|size:8',
                    'motivoTransferido' => 'required|string',
                    'ObservacionesTransferido' => 'required|string',
                ];
                break;
            // Otros casos pueden ser añadidos aquí según sea necesario
        }
        return $rules;
    }
}