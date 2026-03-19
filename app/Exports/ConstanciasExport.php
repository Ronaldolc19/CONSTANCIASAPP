<?php

namespace App\Exports;

use App\Models\Constancia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; // FALTA ESTA LÍNEA
use Maatwebsite\Excel\Concerns\WithMapping;

class ConstanciasExport implements FromCollection,WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Cargamos la relación anidada: estudiante y su respectiva carrera
        return Constancia::with(['estudiante.carrera'])
            ->where('archivado', false)
            ->get();
    }

    public function headings(): array
    {
        return ['ID', 'Estudiante', 'Carrera', 'Fecha de Emisión'];
    }

    public function map($constancia): array
    {
        return [
            $constancia->id,
            $constancia->estudiante?->nombre ?? 'N/A',
            // Acceso correcto: Constancia -> Estudiante -> Carrera
            $constancia->estudiante?->carrera?->nombre ?? 'Sin Carrera',
            $constancia->created_at->format('d/m/Y'),
        ];
    }
}
