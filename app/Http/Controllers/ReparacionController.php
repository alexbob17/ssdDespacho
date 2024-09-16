<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use Illuminate\Http\Request;
use App\Models\Dpto;
use Carbon\Carbon;
use App\Models\Tecnico; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReparacionController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            // Redirigir al usuario al login si no está autenticado
            return redirect()->route('login');
        }
        $dptos = Dpto::all();
        
        // Pasa los datos a la vista
        return view('reparaciones.index', compact('dptos'));
    }

    public function create()
    {
        return view('reparaciones.create');
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
        $tipoOrden = $request->input('tipoOrden');

        // Definir reglas básicas comunes
        $rules = [
            'codigo' => 'required|string',
            'numero' => 'required|string',
            'nombre_tecnico' => 'required|string',
            'Depto' => 'required|string',
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
            'size' => ':attribute debe tener :size dígitos.',
        ];

        // Validar los datos básicos
        $validatedData = $request->validate($rules, $messages);

        $ordenExistente = Reparacion::where('orden', $validatedData['orden'])
        ->where('status', 'Pendiente')
        ->first();

        if ($ordenExistente) {
            // Si existe un registro con la orden y estatus pendiente, retornar un mensaje de error con código 422
            return response()->json([
                'errormsg' => "Boleta pendiente, Orden ya registrada.",
            ], 400);
        }



        // Determinar reglas adicionales en función del tipo de actividad
        switch ($validatedData['tipoactividad']) {
            case 'Realizada':
                $additionalRules = $this->getAdditionalRules($tipoOrden);
                break;
            case 'Objetada':
                $additionalRules = $this->getAdditionalRulesObj($tipoOrden);
                break;
            case 'Transferida':
                $additionalRules = $this->getAdditionalRulesTransf($tipoOrden);
                break;
            default:
                // Tipo de actividad no reconocido
                return response()->json([
                    'errors' => ['Tipo de actividad no reconocido.']
                ]);
        }

        // Agregar reglas adicionales a las reglas básicas
        $rules = array_merge($rules, $additionalRules);

        // Validar nuevamente con todas las reglas
        $validatedData = $request->validate($rules, $messages);

        // Asignar `status` y `user_id` al registro
        $validatedData['status'] = $request->has('status') ? $request->input('status') : 'Pendiente';
        $validatedData['user_id'] = auth()->id();

        // Crear el registro en la tabla de instalaciones
        $reparacion = Reparacion::create($validatedData);

        // Obtener el numConsecutivo generado
        $numConsecutivo = $reparacion->numConsecutivo;

        // Retornar una respuesta JSON con el mensaje de éxito
        return response()->json([
            'redirect_url' => route('reparaciones.index'),
            'message' => "Registro guardado ☑️\n <h3>Boleta #$numConsecutivo </h3>",
            'numConsecutivo' => $numConsecutivo,
        ]);
    }

    public function update(Request $request, $id)
    {
        $tipoOrden = $request->input('tipoOrden');

        // Definir reglas básicas comunes
        $rules = [
            'codigo' => 'required|string',
            'numero' => 'required|string',
            'nombre_tecnico' => 'required|string',
            'Depto' => 'required|string',
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
            'size' => ':attribute debe tener :size dígitos.',
        ];

        // Validar los datos básicos
        $validatedData = $request->validate($rules, $messages);

        // Buscar el registro existente
        $reparacion = Reparacion::find($id);

        if (!$reparacion) {
            return response()->json([
                'error' => 'Registro no encontrado.'
            ], 404);
        }

        // Verificar si la orden ha cambiado y si hay un registro pendiente con la nueva orden
        if ($reparacion->orden !== $validatedData['orden']) {
            $ordenExistente = Reparacion::where('orden', $validatedData['orden'])
                ->where('status', 'Pendiente')
                ->first();

            if ($ordenExistente) {
                return response()->json([
                    'errormsg' => "Boleta pendiente, Orden ya registrada.",
                ], 400);
            }
        }

        // Determinar reglas adicionales en función del tipo de actividad
        switch ($validatedData['tipoactividad']) {
            case 'Realizada':
                $additionalRules = $this->getAdditionalRules($tipoOrden);
                break;
            case 'Objetada':
                $additionalRules = $this->getAdditionalRulesObj($tipoOrden);
                break;
            case 'Transferida':
                $additionalRules = $this->getAdditionalRulesTransf($tipoOrden);
                break;
            default:
                return response()->json([
                    'errors' => ['Tipo de actividad no reconocido.']
                ]);
        }

        // Agregar reglas adicionales a las reglas básicas
        $rules = array_merge($rules, $additionalRules);

        // Validar nuevamente con todas las reglas
        $validatedData = $request->validate($rules, $messages);

        // Asignar `status` y `user_id` al registro
        $validatedData['status'] = $request->has('status') ? $request->input('status') : 'Pendiente';
        $validatedData['user_id'] = auth()->id();

        // Actualizar el registro en la tabla de reparaciones
        $reparacion->update($validatedData);

        return response()->json([
            'redirect_url' => route('busqueda.index'),
            'message' => "Boleta Actualizada ☑️",
        ]);
    }


    protected function getAdditionalRules($tipoOrden)
    {
        $rules = [];
    
        switch ($tipoOrden) {
            case 'REPARACION TV HFC':
                $rules = [
                    'codigocausa' => 'required|string',
                    'tipocausa' => 'required|string',
                    'tipodaño' => 'required|string',
                    'ubicaciondaño' => 'required|string',
                    'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                    'solicitudcambio' => 'nullable|size:8',
                    'comentarios' => 'required|string',
                    'recibe' => 'required|string',
                ];
                break;
            case 'REPARACION INTERNET HFC':
                $rules = [
                    'codigocausa' => 'required|string',
                    'tipocausa' => 'required|string',
                    'tipodaño' => 'required|string',
                    'ubicaciondaño' => 'required|string',
                    'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                    'solicitudcambio' => 'nullable|size:8',
                    'comentarios' => 'required|string',
                    'recibe' => 'required|string',
                ];
                break;
                case 'REPARACION LINEA HFC':
                    $rules = [
                        'codigocausa' => 'required|string',
                        'tipocausa' => 'required|string',
                        'tipodaño' => 'required|string',
                        'ubicaciondaño' => 'required|string',
                        'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                        'solicitudcambio' => 'nullable|size:8',
                        'comentarios' => 'required|string',
                        'recibe' => 'required|string',
                    ];
                    break;
              case 'REPARACION IPTV GPON':
                    $rules = [
                        'codigocausa' => 'required|string',
                        'tipocausa' => 'required|string',
                        'tipodaño' => 'required|string',
                        'ubicaciondaño' => 'required|string',
                        'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                        'solicitudcambio' => 'nullable|size:8',
                        'comentarios' => 'required|string',
                        'recibe' => 'required|string',
                    ];
                    break;
                case 'REPARACION INTERNET GPON':
                    $rules = [
                        'codigocausa' => 'required|string',
                        'tipocausa' => 'required|string',
                        'tipodaño' => 'required|string',
                        'ubicaciondaño' => 'required|string',
                        'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                        'solicitudcambio' => 'nullable|size:8',
                        'comentarios' => 'required|string',
                        'recibe' => 'required|string',
                    ];
                    break;
                case 'REPARACION LINEA GPON':
                    $rules = [
                        'codigocausa' => 'required|string',
                        'tipocausa' => 'required|string',
                        'tipodaño' => 'required|string',
                        'ubicaciondaño' => 'required|string',
                        'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                        'solicitudcambio' => 'nullable|size:8',
                        'comentarios' => 'required|string',
                        'recibe' => 'required|string',
                    ];
                    break;
                case 'REPARACION TV DTH':
                    $rules = [
                        'codigocausa' => 'required|string',
                        'tipocausa' => 'required|string',
                        'tipodaño' => 'required|string',
                        'ubicaciondaño' => 'required|string',
                        'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                        'solicitudcambio' => 'nullable|size:8',
                        'comentarios' => 'required|string',
                        'recibe' => 'required|string',
                    ];
                    break;
                case 'REPARACION LINEA COBRE':
                    $rules = [
                        'codigocausa' => 'required|string',
                        'tipocausa' => 'required|string',
                        'tipodaño' => 'required|string',
                        'ubicaciondaño' => 'required|string',
                        'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                        'solicitudcambio' => 'nullable|size:8',
                        'comentarios' => 'required|string',
                        'recibe' => 'required|string',
                    ];
                    break;
                case 'REPARACION INTERNET ADSL':
                    $rules = [
                        'codigocausa' => 'required|string',
                        'tipocausa' => 'required|string',
                        'tipodaño' => 'required|string',
                        'ubicaciondaño' => 'required|string',
                        'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                        'solicitudcambio' => 'nullable|size:8',
                        'comentarios' => 'required|string',
                        'recibe' => 'required|string',
                    ];
                    break;
            
        }
        return $rules;
    }
    protected function getAdditionalRulesObj($tipoOrden)
    {
        $rules = [];
    
        switch ($tipoOrden) {
            case 'REPARACION TV HFC':
                $rules = [
                    'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                    'motivoObjetada' => 'required|string',
                    'comentariosObjetado' => 'required|string',
                ];
                break;
            case 'REPARACION INTERNET HFC':
                $rules = [
                    'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                    'motivoObjetada' => 'required|string',
                    'comentariosObjetado' => 'required|string',
                ];
                break;
                case 'REPARACION LINEA HFC':
                    $rules = [
                    'orden' => 'required|size:8', 
                    'motivoObjetada' => 'required|string',
                    'comentariosObjetado' => 'required|string',
                    ];
                    break;
              case 'REPARACION IPTV GPON':
                    $rules = [
                        'orden' => 'required|size:8', 
                        'motivoObjetada' => 'required|string',
                        'comentariosObjetado' => 'required|string',
                    ];
                    break;
                case 'REPARACION INTERNET GPON':
                    $rules = [
                        'orden' => 'required|size:8', 
                        'motivoObjetada' => 'required|string',
                        'comentariosObjetado' => 'required|string',
                    ];
                    break;
                case 'REPARACION LINEA GPON':
                    $rules = [
                        'orden' => 'required|size:8', 
                        'motivoObjetada' => 'required|string',
                        'comentariosObjetado' => 'required|string',
                    ];
                    break;
                case 'REPARACION TV DTH':
                    $rules = [
                        'orden' => 'required|size:8', 
                        'motivoObjetada' => 'required|string',
                        'comentariosObjetado' => 'required|string',
                    ];
                    break;
                case 'REPARACION LINEA COBRE':
                    $rules = [
                        'orden' => 'required|size:8', 
                        'motivoObjetada' => 'required|string',
                        'comentariosObjetado' => 'required|string',
                    ];
                    break;
                case 'REPARACION INTERNET ADSL':
                    $rules = [
                        'orden' => 'required|size:8', 
                        'motivoObjetada' => 'required|string',
                        'comentariosObjetado' => 'required|string',
                    ];
                    break;
            
        }
        return $rules;
    }

    protected function getAdditionalRulesTransf($tipoOrden)
    {
        $rules = [];
    
        switch ($tipoOrden) {
            case 'REPARACION TV HFC':
                $rules = [
                    'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                    'ObservacionesTransferida' => 'required|string',
                ];
                break;
            case 'REPARACION INTERNET HFC':
                $rules = [
                    'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                    'ObservacionesTransferida' => 'required|string',
                ];
                break;
                case 'REPARACION LINEA HFC':
                    $rules = [
                        'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                       
                        'ObservacionesTransferida' => 'required|string',
                    ];
                    break;
              case 'REPARACION IPTV GPON':
                $rules = [
                    'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                   
                    'ObservacionesTransferida' => 'required|string',
                ];
                    break;
                case 'REPARACION INTERNET GPON':
                    $rules = [
                        'orden' => 'required|size:8', 
                        'motivoObjetada' => 'nullable|string',
                        'comentariosObjetado' => 'required|string',
                    ];
                    break;
                case 'REPARACION LINEA GPON':
                    $rules = [
                        'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                       
                        'ObservacionesTransferida' => 'required|string',
                    ];
                    break;
                case 'REPARACION TV DTH':
                    $rules = [
                        'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                       
                        'ObservacionesTransferida' => 'required|string',
                    ];
                    break;
                case 'REPARACION LINEA COBRE':
                    $rules = [
                        'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                       
                        'ObservacionesTransferida' => 'required|string',
                    ];
                    break;
                case 'REPARACION INTERNET ADSL':
                    $rules = [
                        'orden' => 'required|size:8', // Validación para exactamente 8 caracteres
                       
                        'ObservacionesTransferida' => 'required|string',
                    ];
                    break;
            
        }
        return $rules;
    }

    
}