<?php

namespace App\Exports;

use App\Models\Tecnico;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TecnicosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Tecnico::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre Técnico',
            'Código',
            'Número',
            'Cédula',
            'Status',
            'Fecha de Creación',
            'Fecha de Actualización',
        ];
    }
}