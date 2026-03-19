<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 1.5cm; }
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.4; }
        .header { text-align: center; border-bottom: 3px solid #007F3F; margin-bottom: 20px; }
        .section-title { background: #007F3F; color: white; padding: 10px; font-weight: bold; margin-top: 30px; text-transform: uppercase; font-size: 14px; }
        .kpi-box { background: #f8f9fa; border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 11px; }
        th { background: #800020; color: white; padding: 8px; text-align: left; }
        td { border: 1px solid #eee; padding: 8px; }
        .chart-box { text-align: center; margin: 20px 0; page-break-inside: avoid; }
        .footer { position: fixed; bottom: 0; width: 100%; font-size: 9px; text-align: center; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="color: #007F3F; margin-bottom: 5px;">INFORME DE GESTIÓN ACADÉMICA</h1>
        <p style="margin: 0;">Reporte Consolidado de Vinculación y Constancias</p>
        <p style="font-size: 12px; color: #666;">Fecha de emisión: {{ $fecha }}</p>
    </div>

    <div class="kpi-box">
        <span style="font-size: 12px; color: #666;">TOTAL DE DOCUMENTOS GESTIONADOS</span><br>
        <strong style="font-size: 28px; color: #007F3F;">{{ $totalConstancias }}</strong>
    </div>

    {{-- BLOQUE 1: PERÍODOS --}}
    <div class="section-title">Análisis de Volumen por Período</div>
    <div class="chart-box">
        <img src="{{ $imgPeriodos }}" style="width: 100%; max-height: 230px;">
        <p style="font-size: 10px; font-style: italic;">Gráfico 1: Evolución cronológica de registros.</p>
    </div>

    {{-- BLOQUE 2: CARRERAS --}}
    <div class="section-title">Distribución por Programa Académico</div>
    <table style="margin-bottom: 20px;">
        <thead>
            <tr>
                <th>Carrera / Licenciatura</th>
                <th style="text-align: center;">Total Emitidas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reporteCarreras as $c)
            <tr>
                <td>{{ $c->nombre }}</td>
                <td style="text-align: center;">{{ $c->constancias_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="chart-box">
        <img src="{{ $imgCarreras }}" style="width: 250px;">
    </div>

    <div style="page-break-after: always;"></div> {{-- Salto de página para profesionalismo --}}

    {{-- BLOQUE 3: EMPRESAS --}}
    <div class="section-title">Impacto en Sector Externo (Empresas)</div>
    <p style="font-size: 12px;">A continuación se detallan las organizaciones con mayor índice de vinculación estudiantil en el presente ciclo:</p>
    
    <div class="chart-box">
        <img src="{{ $imgEmpresas }}" style="width: 100%; max-height: 280px;">
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre de la Empresa / Institución</th>
                <th style="text-align: center;">Alumnos Vinculados</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reporteEmpresas as $e)
            <tr>
                <td>{{ $e->nombre }}</td>
                <td style="text-align: center;">{{ $e->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Documento generado automáticamente por el Sistema de Gestión Institucional. Todos los datos están basados en registros archivables del ciclo escolar vigente.
    </div>
</body>
</html>