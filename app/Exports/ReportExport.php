<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $reportType;

    public function __construct($data, $reportType)
    {
        $this->data = $data;
        $this->reportType = $reportType;
    }

    public function collection()
    {
        return collect($this->data->map(function ($item) {
            switch ($this->reportType) {
                case 'instalaciones':
                    return [
                        $item->codigo_tecnico,
                        $item->numero,
                    ];
                case 'reparacion':
                    return [
                        $item->descripcion,
                    ];
                case 'postventa':
                    return [
                        $item->descripcion,
                    ];
                case 'consulta':
                    return [
                        $item->codigo_tecnico,
                        $item->numero,
                        $item->nombre_tecnico,
                        $item->motivo_consulta,
                        $item->numero_orden,
                        $item->observaciones,
                        $item->idconsulta,
                        $item->user_id,
                    ];
                case 'agendamiento':
                    return [
                        $item->descripcion,
                    ];
                default:
                    return [];
            }
        }));
    }

    public function headings(): array
    {
        switch ($this->reportType) {
            case 'instalaciones':
                return ['Código Técnico', 'Número'];
            case 'reparacion':
                return ['Descripción'];
            case 'postventa':
                return ['Descripción'];
            case 'consulta':
                return ['Código Técnico', 'Número', 'Nombre Técnico', 'Motivo Consulta', 'Número de Orden', 'Observaciones', 'ID Consulta', 'ID Usuario'];
            case 'agendamiento':
                return ['Descripción'];
            default:
                return [];
        }
    }
}