<?php

// app/Exports/ConsultasExport.php

namespace App\Exports;

use App\Models\Consulta;
use Maatwebsite\Excel\Concerns\FromCollection;

class ConsultasExport implements FromCollection
{
    public function collection()
    {
        return Consulta::all(); // O ajusta el query según sea necesario
    }
}