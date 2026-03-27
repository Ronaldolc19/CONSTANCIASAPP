<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Constancias Emitidas - {{ $fecha }}</title>
    <style>
        @page { margin: 1cm 1.5cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #2c3e50; line-height: 1.5; font-size: 10pt; background-color: #fff; }
        .header { border-bottom: 2px solid #007F3F; padding-bottom: 10px; margin-bottom: 25px; }
        .header-table { width: 100%; border: none; }
        .inst-logo { color: #007F3F; font-size: 18pt; font-weight: bold; }
        .report-type { background: #800020; color: white; padding: 4px 10px; font-size: 8pt; border-radius: 4px; text-transform: uppercase; }
        
        /* Bloque de Impacto: Solo Emitidas */
        .main-kpi-wrapper {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f0f9f4;
            border: 2px solid #007F3F;
            border-radius: 12px;
            text-align: center;
        }
        .main-kpi-label { display: block; color: #007F3F; font-size: 10pt; text-transform: uppercase; font-weight: bold; margin-bottom: 5px; }
        .main-kpi-value { font-size: 36pt; color: #1a252f; display: block; line-height: 1; font-weight: bold; }

        .section { margin-bottom: 35px; clear: both; }
        .section-header { border-left: 4px solid #007F3F; padding-left: 10px; margin-bottom: 15px; font-size: 11pt; font-weight: bold; text-transform: uppercase; }
        .chart-box { width: 100%; text-align: center; margin-bottom: 15px; }
        .chart-img { max-width: 400px; height: auto; border: 1px solid #eee; padding: 8px; border-radius: 5px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #007F3F; color: white; font-size: 8.5pt; padding: 10px; text-align: left; }
        td { padding: 8px 10px; border-bottom: 1px solid #eee; font-size: 8.5pt; }
        .text-right { text-align: right; }
        
        .analysis-text { background: #fdfdfd; border: 1px solid #eee; padding: 10px; border-radius: 5px; font-size: 8.5pt; color: #666; font-style: italic; margin-top: 10px; }

        .footer { position: fixed; bottom: 0; width: 100%; font-size: 7pt; color: #adb5bd; text-align: center; border-top: 1px solid #eee; padding-top: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <table class="header-table">
            <tr>
                <td width="70%">
                    <div class="inst-logo">VIBEOSCURO <span style="font-weight: 300; color: #666;">Admin</span></div>
                    <div style="font-size: 9pt; color: #7f8c8d;">Informe Técnico</div>
                </td>
                <td width="30%" class="text-right">
                    <span class="report-type">Reporte de Emisiones</span>
                    <div style="margin-top: 5px; font-size: 8pt;">{{ $fecha }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- 1. TOTAL DE EMITIDAS --}}
    <div class="main-kpi-wrapper">
        <span class="main-kpi-label">Total de Constancias Validadas y Emitidas</span>
        <span class="main-kpi-value">{{ number_format($totalConstancias) }}</span>
        <p style="color: #666; font-size: 8pt; margin-top: 10px;">
            * Este número excluye solicitudes pendientes, canceladas o en proceso de revisión.
        </p>
    </div>

    {{-- 2. DISTRIBUCIÓN POR CARRERA --}}
    <div class="section">
        <div class="section-header">1. Distribución por Programa Académico</div>
        <div class="chart-box">
            <img src="{{ $imgCarreras }}" class="chart-img" style="max-width: 280px;">
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Carrera / Programa</th>
                    <th class="text-right">Emitidas</th>
                    <th class="text-right">Participación (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reporteCarreras as $carrera)
                <tr>
                    <td>{{ $carrera->nombre }}</td>
                    <td class="text-right" style="font-weight: bold;">{{ $carrera->constancias_count }}</td>
                    <td class="text-right">{{ $totalConstancias > 0 ? number_format(($carrera->constancias_count / $totalConstancias) * 100, 1) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="page-break-after: always;"></div>

    {{-- 3. VINCULACIÓN EMPRESARIAL --}}
    <div class="section">
        <div class="section-header">2. Top 10 Instituciones de Vinculación</div>
        <div class="chart-box">
            <img src="{{ $imgEmpresas }}" class="chart-img">
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Institución / Empresa Receptor</th>
                    <th class="text-right">Constancias Entregadas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reporteEmpresas as $empresa)
                <tr>
                    <td>{{ $empresa->nombre }}</td>
                    <td class="text-right" style="font-weight: bold; color: #800020;">{{ $empresa->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- 4. CRONOLOGÍA POR PERIODOS (AQUÍ ESTÁ LO QUE FALTABA) --}}
    <div class="section">
        <div class="section-header">3. Histórico de Emisiones por Período Académico</div>
        <div class="chart-box">
            <img src="{{ $imgPeriodos }}" class="chart-img" style="max-width: 450px;">
        </div>
        <div class="analysis-text">
            Este gráfico detalla el flujo de documentos que han alcanzado el estado de <strong>"Emitido"</strong> dentro de los rangos de fechas definidos en la configuración de períodos.
        </div>
    </div>

    <div class="footer">
        Este documento certifica únicamente las constancias con estatus "Emitida" en el sistema ConstanciasApp.
    </div>

</body>
</html>