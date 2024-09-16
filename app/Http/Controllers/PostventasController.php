<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dpto;
use App\Models\Postventa;
use Carbon\Carbon;
use App\Models\Anulacion;
use App\Models\Tecnico; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostventasController extends Controller
{
    //

    public function index()
    {

        if (!auth()->check()) {
            // Redirigir al usuario al login si no está autenticado
            return redirect()->route('login');
        }
        $dptos = Dpto::all();
        $anulacion = Anulacion::all();

        
        // Pasa los datos a la vista
        return view('postventas.index', compact('dptos'), compact('anulacion'));
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
            'status' => 'nullable|string',
            'orden' => 'nullable|string',
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

        $ordenExistente = Postventa::where('orden', $validatedData['orden'])
        ->where('status', 'Pendiente')
        ->first();

        if ($ordenExistente) {
            // Si existe un registro con la orden y estatus pendiente, retornar un mensaje de error con código 422
            return response()->json([
                'errormsg' => "Boleta pendiente, Orden ya registrada.",
            ], 400);
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
        $postventas = Postventa::create($validatedData);

        // Retornar una respuesta JSON con el mensaje de éxito
         // Obtener el numConsecutivo generado
        $numConsecutivo = $postventas->numConsecutivo;

         // Retornar una respuesta JSON con el mensaje de éxito
        return response()->json([
             'redirect_url' => route('postventas.index'),
             'message' => "Registro guardado ☑️\n <h3>Boleta #$numConsecutivo </h3>",
             'numConsecutivo' => $numConsecutivo,
         ]);
    }

    public function update(Request $request, $id)
    {
        // Definir reglas básicas comunes
        $rules = [
            'codigo' => 'required|string',
            'numero' => 'required|string',
            'nombre_tecnico' => 'required|string',
            'depto' => 'required|string',
            'tipoactividad' => 'required|string',
            'tipoOrden' => 'required|string',
            'status' => 'nullable|string',
            'orden' => 'nullable|string',
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

        // Buscar el registro existente por ID
        $postventa = Postventa::findOrFail($id);

        // Verificar si la orden ha cambiado y si ya existe una con estado 'Pendiente'
        if ($postventa->orden !== $validatedData['orden']) {
            $ordenExistente = Postventa::where('orden', $validatedData['orden'])
                ->where('status', 'Pendiente')
                ->first();

            if ($ordenExistente) {
                return response()->json([
                    'errormsg' => "Boleta pendiente, Orden ya registrada.",
                ], 400);
            }
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

        // Asignar `status` al registro si está presente en el request
        $validatedData['status'] = $request->input('status', 'Pendiente');

        // Actualizar el registro en la tabla de postventas
        $postventa->update($validatedData);


        // Retornar una respuesta JSON con el mensaje de éxito
        return response()->json([
            'redirect_url' => route('busqueda.index'),
            'message' => "Registro actualizado ☑️",
        ]);
    }

    

    protected function getAdditionalRules($tipoOrden)
    {
        $rules = [];
    
        switch ($tipoOrden) {
            case 'TRASLADO TRIPLE HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'nodo' => 'required|string',
                    'tap_caja' => 'required|string',
                    'materiales' => 'required|string',
                    'posicion_puerto' => 'required|string',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                ];
                break;
            case 'TRASLADO DOBLE HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'nodo' => 'required|string',
                    'tap_caja' => 'required|string',
                    'materiales' => 'required|string',
                    'posicion_puerto' => 'required|string',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                ];
                break;
            case 'TRASLADO INDIVIDUAL HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'nodo' => 'required|string',
                    'tap_caja' => 'required|string',
                    'materiales' => 'required|string',
                    'posicion_puerto' => 'required|string',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                ];
                break;
            case 'TRASLADO TRIPLE GPON':
                $rules = [
                    'orden' => 'required|size:8',
                    'nodo' => 'required|string',
                    'tap_caja' => 'required|string',
                    'materiales' => 'required|string',
                    'posicion_puerto' => 'required|string',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                ];
                break;
            case 'TRASLADO DOBLE GPON':
                $rules = [
                    'orden' => 'required|size:8',
                    'nodo' => 'required|string',
                    'tap_caja' => 'required|string',
                    'materiales' => 'required|string',
                    'posicion_puerto' => 'required|string',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                ];
                break;
            case 'TRASLADO INDIVIDUAL GPON':
                $rules = [
                    'orden' => 'required|size:8',
                    'nodo' => 'required|string',
                    'tap_caja' => 'required|string',
                    'materiales' => 'required|string',
                    'posicion_puerto' => 'required|string',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                ];
                break;
            case 'TRASLADO ADSL':
                $rules = [
                    'orden' => 'required|size:8',
                    'coordenadas' => 'required|string',
                    'materiales' => 'required|string',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                ];
                break;
            case 'TRASLADO COBRE':
                $rules = [
                    'orden' => 'required|size:8',
                    'coordenadas' => 'required|string',
                    'materiales' => 'required|string',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                ];
                break;
            case 'TRASLADO DTH':
                $rules = [
                    'orden' => 'required|size:8',
                    'coordenadas' => 'required|string',
                    'materiales' => 'required|string',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                ];
                break;
             case 'ADICION ANOLOGA HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                    'equipotv1' => 'required|string',
                    'equipotv2' => 'nullable|string',
                    'equipotv3' => 'nullable|string',
                    'equipotv4' => 'nullable|string',
                    'equipotv5' => 'nullable|string',
                ];
                break;
            case 'ADICION DTA HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                    'equipotv1' => 'required|string',
                    'equipotv2' => 'nullable|string',
                    'equipotv3' => 'nullable|string',
                    'equipotv4' => 'nullable|string',
                    'equipotv5' => 'nullable|string',
                ];
                break;
            case 'ADICION DIGITAL HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                    'equipotv1' => 'required|string',
                    'equipotv2' => 'nullable|string',
                    'equipotv3' => 'nullable|string',
                    'equipotv4' => 'nullable|string',
                    'equipotv5' => 'nullable|string',
                ];
                break;
            case 'ADICION IPTV GPON':
                $rules = [
                    'orden' => 'required|size:8',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                    'equipotv1' => 'required|string',
                    'equipotv2' => 'nullable|string',
                    'equipotv3' => 'nullable|string',
                    'equipotv4' => 'nullable|string',
                    'equipotv5' => 'nullable|string',
                ];
                break;
            case 'ADICION TV DTH':
                $rules = [
                    'orden' => 'required|size:8',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                    'equipotv1' => 'required|string',
                    'equipotv2' => 'nullable|string',
                    'equipotv3' => 'nullable|string',
                    'equipotv4' => 'nullable|string',
                    'equipotv5' => 'nullable|string',
                ];
                break;
            case 'CAMBIO DE EQUIPO TV HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'observaciones' => 'required|string',
                    'recibe' => 'required|string',
                    'equipotv1' => 'required|string',
                    'equipotv2' => 'nullable|string',
                    'equipotv3' => 'nullable|string',
                    'equipotv4' => 'nullable|string',
                    'equipotv5' => 'nullable|string',
                    'equipotvretira1' => 'required|string',
                    'equipotvretira2' => 'nullable|string',
                    'equipotvretira3' => 'nullable|string',
                    'equipotvretira4' => 'nullable|string',
                    'equipotvretira5' => 'nullable|string',
                    
                ];
                break;
            case 'CAMBIO DE EQUIPO INTERNET HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'observaciones' => 'required|string',
                        'recibe' => 'required|string',
                        'equipomodem' => 'required|string',
                        'equipomodemret' => 'required|string',
                    ];
                    break;
                case 'CAMBIO DE EQUIPO INTERNET GPON':
                    $rules = [
                        'orden' => 'required|size:8',
                        'observaciones' => 'required|string',
                        'recibe' => 'required|string',
                        'equipomodem' => 'required|string',
                        'equipomodemret' => 'required|string',
                    ];
                    break;
                 case 'CAMBIO DE EQUIPO TV GPON':
                    $rules = [
                        'orden' => 'required|size:8',
                        'observaciones' => 'required|string',
                        'recibe' => 'required|string',
                        'equipotv1' => 'required|string',
                        'equipotv2' => 'nullable|string',
                        'equipotv3' => 'nullable|string',
                        'equipotv4' => 'nullable|string',
                        'equipotv5' => 'nullable|string',
                        'equipotvretira1' => 'required|string',
                        'equipotvretira2' => 'nullable|string',
                        'equipotvretira3' => 'nullable|string',
                        'equipotvretira4' => 'nullable|string',
                        'equipotvretira5' => 'nullable|string',
                        
                    ];
                    break;
                case 'CAMBIO DE EQUIPO TV DTH':
                        $rules = [
                            'orden' => 'required|size:8',
                            'observaciones' => 'required|string',
                            'recibe' => 'required|string',
                            'equipotv1' => 'required|string',
                            'equipotv2' => 'nullable|string',
                            'equipotv3' => 'nullable|string',
                            'equipotv4' => 'nullable|string',
                            'equipotv5' => 'nullable|string',
                            'equipotvretira1' => 'required|string',
                            'equipotvretira2' => 'nullable|string',
                            'equipotvretira3' => 'nullable|string',
                            'equipotvretira4' => 'nullable|string',
                            'equipotvretira5' => 'nullable|string',
                            
                        ];
                        break;
                 case 'CAMBIO DE EQUIPO ADSL':
                    $rules = [
                        'orden' => 'required|size:8',
                        'observaciones' => 'required|string',
                        'recibe' => 'required|string',
                        'equipomodem' => 'required|string',
                        'equipomodemret' => 'required|string',
                        
                    ];
                    break;
                case 'MIGRACION DTA HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'observaciones' => 'required|string',
                        'recibe' => 'required|string',
                        'equipotv1' => 'required|string',
                        'equipotv2' => 'nullable|string',
                        'equipotv3' => 'nullable|string',
                        'equipotv4' => 'nullable|string',
                        'equipotv5' => 'nullable|string',
                        'nodo' => 'required|string',
                        'tap_caja' => 'required|string',
                        'materiales' => 'required|string',
                        'posicion_puerto' => 'required|string',
                    ];
                    break;
                case 'MIGRACION DIGITAL HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'observaciones' => 'required|string',
                        'recibe' => 'required|string',
                        'equipotv1' => 'required|string',
                        'equipotv2' => 'nullable|string',
                        'equipotv3' => 'nullable|string',
                        'equipotv4' => 'nullable|string',
                        'equipotv5' => 'nullable|string',
                            'nodo' => 'required|string',
                        'tap_caja' => 'required|string',
                        'materiales' => 'required|string',
                        'posicion_puerto' => 'required|string',
                    ];
                    break;
                case 'MIGRACION X PROYECTO HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'observaciones' => 'required|string',
                        'recibe' => 'required|string',
                        'equipotv1' => 'required|string',
                        'equipotv2' => 'nullable|string',
                        'equipotv3' => 'nullable|string',
                        'equipotv4' => 'nullable|string',
                        'equipotv5' => 'nullable|string',
                        'nodo' => 'required|string',
                        'tap_caja' => 'required|string',
                        'materiales' => 'required|string',
                        'posicion_puerto' => 'required|string',
                    ];
                    break;
                case 'RECONEXION HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'observaciones' => 'required|string',
                        'recibe' => 'required|string',
                        'materiales' => 'required|string',
                    ];
                    break;
                case 'RETIRO ACOMETIDO HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'observaciones' => 'required|string',
                        'recibe' => 'required|string',
                        'materiales' => 'required|string',
                    ];
                    break;
                case 'RETIRO EQUIPOS STB HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'observaciones' => 'required|string',
                        'recibe' => 'required|string',
                        'materiales' => 'required|string',
                        'equipotvretira1' => 'required|string',
                        'equipotvretira2' => 'nullable|string',
                        'equipotvretira3' => 'nullable|string',
                        'equipotvretira4' => 'nullable|string',
                        'equipotvretira5' => 'nullable|string',
                    ];
                    break;
                case 'RETIRO EQUIPOS CM HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'observaciones' => 'required|string',
                        'recibe' => 'required|string',
                        'materiales' => 'required|string',
                    ];
                    break;
                case 'RETIRO EQUIPOS STB DTH':
                    $rules = [
                        'orden' => 'required|size:8',
                        'observaciones' => 'required|string',
                        'recibe' => 'required|string',
                        'materiales' => 'required|string',
                        'equipotvretira1' => 'required|string',
                        'equipotvretira2' => 'nullable|string',
                        'equipotvretira3' => 'nullable|string',
                        'equipotvretira4' => 'nullable|string',
                        'equipotvretira5' => 'nullable|string',
                    ];
                    break;
                case 'CAMBIO NUMERO COBRE':
                    $rules = [
                        'orden' => 'required|size:8',
                        'observaciones' => 'required|string',
                        'recibe' => 'required|string',
                        'numerocobre' => 'required|string',
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
            case 'TRASLADO TRIPLE HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'TRASLADO DOBLE HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'TRASLADO INDIVIDUAL HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'TRASLADO TRIPLE GPON':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'TRASLADO DOBLE GPON':
                $rules = [
                   'orden' => 'required|size:8',
                   'motivoObjetada' => 'required|string',
                   'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'TRASLADO INDIVIDUAL GPON':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'TRASLADO ADSL':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'TRASLADO COBRE':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'TRASLADO DTH':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
             case 'ADICION ANOLOGA HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'ADICION DTA HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'ADICION DIGITAL HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'ADICION IPTV GPON':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'ADICION TV DTH':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                ];
                break;
            case 'CAMBIO DE EQUIPO TV HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoObjetada' => 'required|string',
                    'ObservacionesObj' => 'required|string',
                    
                ];
                break;
            case 'CAMBIO DE EQUIPO INTERNET HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoObjetada' => 'required|string',
                        'ObservacionesObj' => 'required|string',
                    ];
                    break;
                case 'CAMBIO DE EQUIPO INTERNET GPON':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoObjetada' => 'required|string',
                        'ObservacionesObj' => 'required|string',
                    ];
                    break;
                 case 'CAMBIO DE EQUIPO TV GPON':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoObjetada' => 'required|string',
                        'ObservacionesObj' => 'required|string',
                    ];
                    break;
                case 'CAMBIO DE EQUIPO TV DTH':
                        $rules = [
                            'orden' => 'required|size:8',
                            'motivoObjetada' => 'required|string',
                            'ObservacionesObj' => 'required|string',
                        ];
                        break;
                 case 'CAMBIO DE EQUIPO ADSL':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoObjetada' => 'required|string',
                        'ObservacionesObj' => 'required|string',
                        
                    ];
                    break;
                case 'MIGRACION DTA HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoObjetada' => 'required|string',
                        'ObservacionesObj' => 'required|string',
                    ];
                    break;
                case 'MIGRACION DIGITAL HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoObjetada' => 'required|string',
                        'ObservacionesObj' => 'required|string',
                    ];
                    break;
                case 'MIGRACION X PROYECTO HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoObjetada' => 'required|string',
                        'ObservacionesObj' => 'required|string',
                    ];
                    break;
                case 'RECONEXION HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoObjetada' => 'required|string',
                        'ObservacionesObj' => 'required|string',
                    ];
                    break;
                case 'RETIRO ACOMETIDO HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoObjetada' => 'required|string',
                        'ObservacionesObj' => 'required|string',
                    ];
                    break;
                case 'RETIRO EQUIPOS STB HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoObjetada' => 'required|string',
                        'ObservacionesObj' => 'required|string',
                    ];
                    break;
                case 'RETIRO EQUIPOS CM HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoObjetada' => 'required|string',
                        'ObservacionesObj' => 'required|string',
                    ];
                    break;
                case 'RETIRO EQUIPOS STB DTH':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoObjetada' => 'required|string',
                        'ObservacionesObj' => 'required|string',
                    ];
                    break;
                case 'CAMBIO NUMERO COBRE':
                    $rules = [
                        'orden' => 'required|size:8',
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
            case 'TRASLADO TRIPLE HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'ObservacionesAnuladas' => 'required|string',
                    'motivoAnulada' => 'required|string',
                ];
                break;
            case 'TRASLADO DOBLE HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'ObservacionesAnuladas' => 'required|string',
                    'motivoAnulada' => 'required|string',
                ];
                break;
            case 'TRASLADO INDIVIDUAL HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'ObservacionesAnuladas' => 'required|string',
                    'motivoAnulada' => 'required|string',
                ];
                break;
            case 'TRASLADO TRIPLE GPON':
                $rules = [
                    'orden' => 'required|size:8',
                    'ObservacionesAnuladas' => 'required|string',
                    'motivoAnulada' => 'required|string',
                ];
                break;
            case 'TRASLADO DOBLE GPON':
                $rules = [
                   'orden' => 'required|size:8',
                   'ObservacionesAnuladas' => 'required|string',
                    'motivoAnulada' => 'required|string',
                ];
                break;
            case 'TRASLADO INDIVIDUAL GPON':
                $rules = [
                    'orden' => 'required|size:8',
                    'ObservacionesAnuladas' => 'required|string',
                    'motivoAnulada' => 'required|string',
                ];
                break;
            case 'TRASLADO ADSL':
                $rules = [
                    'orden' => 'required|size:8',
                    'ObservacionesAnuladas' => 'required|string',
                    'motivoAnulada' => 'required|string',
                ];
                break;
            case 'TRASLADO COBRE':
                $rules = [
                    'orden' => 'required|size:8',
                    'ObservacionesAnuladas' => 'required|string',
                    'motivoAnulada' => 'required|string',
                ];
                break;
            case 'TRASLADO DTH':
                $rules = [
                    'orden' => 'required|size:8',
                    'ObservacionesAnuladas' => 'required|string',
                    'motivoAnulada' => 'required|string',
                ];
                break;
             case 'ADICION ANOLOGA HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'ObservacionesAnuladas' => 'required|string',
                    'motivoAnulada' => 'required|string',
                ];
                break;
            case 'ADICION DTA HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'ObservacionesAnuladas' => 'required|string',
                    'motivoAnulada' => 'required|string',
                ];
                break;
            case 'ADICION DIGITAL HFC':
                $rules = [
                    'orden' => 'required|size:8',
                   'ObservacionesAnuladas' => 'required|string',
                    'motivoAnulada' => 'required|string',
                ];
                break;
            case 'ADICION IPTV GPON':
                $rules = [
                    'orden' => 'required|size:8',
                    'ObservacionesAnuladas' => 'required|string',
                    'motivoAnulada' => 'required|string',
                ];
                break;
            case 'ADICION TV DTH':
                $rules = [
                    'orden' => 'required|size:8',
                    'ObservacionesAnuladas' => 'required|string',
                    'motivoAnulada' => 'required|string',
                ];
                break;
            case 'CAMBIO DE EQUIPO TV HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'ObservacionesAnuladas' => 'required|string',
                    'motivoAnulada' => 'required|string',
                    
                ];
                break;
            case 'CAMBIO DE EQUIPO INTERNET HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'ObservacionesAnuladas' => 'required|string',
                        'motivoAnulada' => 'required|string',
                    ];
                    break;
                case 'CAMBIO DE EQUIPO INTERNET GPON':
                    $rules = [
                        'orden' => 'required|size:8',
                        'ObservacionesAnuladas' => 'required|string',
                        'motivoAnulada' => 'required|string',
                    ];
                    break;
                 case 'CAMBIO DE EQUIPO TV GPON':
                    $rules = [
                        'orden' => 'required|size:8',
                        'ObservacionesAnuladas' => 'required|string',
                        'motivoAnulada' => 'required|string',
                    ];
                    break;
                case 'CAMBIO DE EQUIPO TV DTH':
                        $rules = [
                            'orden' => 'required|size:8',
                            'ObservacionesAnuladas' => 'required|string',
                            'motivoAnulada' => 'required|string',
                        ];
                        break;
                 case 'CAMBIO DE EQUIPO ADSL':
                    $rules = [
                        'orden' => 'required|size:8',
                        'ObservacionesAnuladas' => 'required|string',
                        'motivoAnulada' => 'required|string',
                    ];
                    break;
                case 'MIGRACION DTA HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'ObservacionesAnuladas' => 'required|string',
                        'motivoAnulada' => 'required|string',
                    ];
                    break;
                case 'MIGRACION DIGITAL HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'ObservacionesAnuladas' => 'required|string',
                        'motivoAnulada' => 'required|string',
                    ];
                    break;
                case 'MIGRACION X PROYECTO HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'ObservacionesAnuladas' => 'required|string',
                        'motivoAnulada' => 'required|string',
                    ];
                    break;
                case 'RECONEXION HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'ObservacionesAnuladas' => 'required|string',
                        'motivoAnulada' => 'required|string',
                    ];
                    break;
                case 'RETIRO ACOMETIDO HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'ObservacionesAnuladas' => 'required|string',
                        'motivoAnulada' => 'required|string',
                    ];
                    break;
                case 'RETIRO EQUIPOS STB HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'ObservacionesAnuladas' => 'required|string',
                        'motivoAnulada' => 'required|string',
                    ];
                    break;
                case 'RETIRO EQUIPOS CM HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'ObservacionesAnuladas' => 'required|string',
                        'motivoAnulada' => 'required|string',
                    ];
                    break;
                case 'RETIRO EQUIPOS STB DTH':
                    $rules = [
                        'orden' => 'required|size:8',
                        'ObservacionesAnuladas' => 'required|string',
                        'motivoAnulada' => 'required|string',
                    ];
                    break;
                case 'CAMBIO NUMERO COBRE':
                    $rules = [
                        'orden' => 'required|size:8',
                        'ObservacionesAnuladas' => 'required|string',
                        'motivoAnulada' => 'required|string',
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
            case 'TRASLADO TRIPLE HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoTransferido' => 'required|string',
                ];
                break;
            case 'TRASLADO DOBLE HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoTransferido' => 'required|string',

                ];
                break;
            case 'TRASLADO INDIVIDUAL HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoTransferido' => 'required|string',

                ];
                break;
            case 'TRASLADO TRIPLE GPON':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoTransferido' => 'required|string',

                ];
                break;
            case 'TRASLADO DOBLE GPON':
                $rules = [
                   'orden' => 'required|size:8',
                   'motivoTransferido' => 'required|string',

                ];
                break;
            case 'TRASLADO INDIVIDUAL GPON':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoTransferido' => 'required|string',

                ];
                break;
            case 'TRASLADO ADSL':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoTransferido' => 'required|string',

                ];
                break;
            case 'TRASLADO COBRE':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoTransferido' => 'required|string',

                ];
                break;
            case 'TRASLADO DTH':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoTransferido' => 'required|string',

                ];
                break;
             case 'ADICION ANOLOGA HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoTransferido' => 'required|string',

                ];
                break;
            case 'ADICION DTA HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoTransferido' => 'required|string',

                ];
                break;
            case 'ADICION DIGITAL HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoTransferido' => 'required|string',

                ];
                break;
            case 'ADICION IPTV GPON':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoTransferido' => 'required|string',

                ];
                break;
            case 'ADICION TV DTH':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoTransferido' => 'required|string',

                ];
                break;
            case 'CAMBIO DE EQUIPO TV HFC':
                $rules = [
                    'orden' => 'required|size:8',
                    'motivoTransferido' => 'required|string',

                    
                ];
                break;
            case 'CAMBIO DE EQUIPO INTERNET HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoTransferido' => 'required|string',

                    ];
                    break;
                case 'CAMBIO DE EQUIPO INTERNET GPON':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoTransferido' => 'required|string',

                    ];
                    break;
                 case 'CAMBIO DE EQUIPO TV GPON':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoTransferido' => 'required|string',

                    ];
                    break;
                case 'CAMBIO DE EQUIPO TV DTH':
                        $rules = [
                            'orden' => 'required|size:8',
                            'motivoTransferido' => 'required|string',

                        ];
                        break;
                 case 'CAMBIO DE EQUIPO ADSL':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoTransferido' => 'required|string',

                        
                    ];
                    break;
                case 'MIGRACION DTA HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoTransferido' => 'required|string',

                    ];
                    break;
                case 'MIGRACION DIGITAL HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoTransferido' => 'required|string',

                    ];
                    break;
                case 'MIGRACION X PROYECTO HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoTransferido' => 'required|string',

                    ];
                    break;
                case 'RECONEXION HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoTransferido' => 'required|string',

                    ];
                    break;
                case 'RETIRO ACOMETIDO HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoTransferido' => 'required|string',

                    ];
                    break;
                case 'RETIRO EQUIPOS STB HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoTransferido' => 'required|string',

                    ];
                    break;
                case 'RETIRO EQUIPOS CM HFC':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoTransferido' => 'required|string',

                    ];
                    break;
                case 'RETIRO EQUIPOS STB DTH':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoTransferido' => 'required|string',

                    ];
                    break;
                case 'CAMBIO NUMERO COBRE':
                    $rules = [
                        'orden' => 'required|size:8',
                        'motivoTransferido' => 'required|string',
                    ];
                    break;

            // Otros casos pueden ser añadidos aquí según sea necesario
        }
        return $rules;
    }

}