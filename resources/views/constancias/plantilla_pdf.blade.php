<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Constancia - {{ $constancia->estudiante->nombre }} {{ $constancia->estudiante->ap }} {{ $constancia->estudiante->am }}</title>

<style>
  body {
    font-family: "Times New Roman", Times, serif;
    font-size: 12pt;
    margin: 40px 60px;
    color: #000;
    line-height: 1.25;
  }
  header { display: block; width: 100%; margin-bottom: 10px; }
  .logo-left { position: absolute; left: 60px; top: 30px; width: 120px; height: 80px; }
  .seal-right { position: absolute; right: 60px; top: 30px; width: 120px; height: 120px; }
  .title { text-align: center; font-weight: bold; font-size: 18pt; margin-top: 40px; margin-bottom: 18px; }
  .justify { text-align: justify; }
  .center { text-align: center; }
  .right { text-align: right; }
  .indent { text-indent: 30px; }
  .big-space { margin-top: 36px; }
  .space { margin-top: 12px; }
  .signature-block { margin-top: 60px; text-align: center; }
  .signature-name { font-weight: bold; }
  .registro { margin-top: 20px; text-align: center; font-weight: bold; }
  .line-seal { width: 60%; height: 1px; background:#000; margin: 14px auto; }
  footer { position: fixed; bottom: 30px; left: 60px; right: 60px; font-size: 10pt; text-align: center; }
</style>
</head>

<body>

<header>
  <div class="logo-left"></div>
  <div class="seal-right"></div>
</header>

<main>

  <div class="title">CONSTANCIA</div>

  <div class="space">
    <div class="bold">
      A: <span class="underline">
        {{ $constancia->estudiante->nombre }} 
        {{ $constancia->estudiante->ap }} 
        {{ $constancia->estudiante->am }}
      </span>
    </div>
  </div>

  <!-- Primer párrafo con género -->
  <div class="space justify">
    <p>
      <span class="bold">{{ $alumn }}</span>
      del Programa de Estudios de 
      <span class="bold">{{ $constancia->estudiante->carrera->nombre }}</span>,
      con número de cuenta <span class="bold">{{ $constancia->estudiante->no_cuenta }}</span>,
      en virtud de haber cumplido su prestación; quien estuvo 
      <span class="bold">{{ $adscripcion }}</span> en
      <span class="bold">{{ $constancia->empresa->nombre }}</span> durante el periodo
      <span class="bold">{{ $constancia->periodo->periodo_formateado }}</span>.
    </p>
  </div>

  <!-- Segundo párrafo -->
  <div class="space justify">
    <p>
      Con fundamento en los Artículos 14, Fracción IX y 35 del Reglamento del Servicio Social del Estado de México;
      se expide la presente en la ciudad típica de Valle de Bravo, Estado de México, a los
      <span class="bold">{{ \Carbon\Carbon::parse($constancia->fecha_emision)->translatedFormat('d \d\e F \d\e Y') }}</span>.
    </p>
  </div>

  <div class="big-space"></div>

  <!-- SECCIÓN DUPLICADA (mantengo tu diseño original) -->
  <div class="space">
    <div class="bold">A: 
      <span class="underline">{{ $constancia->estudiante->nombre }} {{ $constancia->estudiante->ap }} {{ $constancia->estudiante->am }}</span>
    </div>
  </div>

  <div class="space justify">
    <p>
      <span class="bold">{{ $alumn }}</span>
      del Programa de Estudios de 
      <span class="bold">{{ $constancia->estudiante->carrera->nombre }}</span>,
      con número de cuenta <span class="bold">{{ $constancia->estudiante->no_cuenta }}</span>,
      en virtud de haber cumplido su prestación; quien estuvo 
      <span class="bold">{{ $adscripcion }}</span> en
      <span class="bold">{{ $constancia->empresa->nombre }}</span> durante el periodo
      <span class="bold">{{ $constancia->periodo->periodo_formateado }}</span>.
    </p>
  </div>

  <div class="space justify">
    <p>
      Con fundamento en los Artículos 14, Fracción IX y 35 del Reglamento del Servicio Social del Estado de México;
      se expide la presente en la ciudad típica de Valle de Bravo, Estado de México, a los
      <span class="bold">{{ \Carbon\Carbon::parse($constancia->fecha_emision)->translatedFormat('d \d\e F \d\e Y') }}</span>.
    </p>
  </div>

  <div class="big-space"></div>

  <div class="center">
    <div class="line-seal"></div>
    <div class="italic">[Espacio para sello institucional]</div>
  </div>

  <div class="registro">
    <div>{{ $constancia->no_registro }}</div>
    <div class="space">{{ $constancia->no_registro }}</div>
  </div>

  <div class="signature-block">
    <div class="signature-name">Dr. Fidel Argenis Flores Quiroz</div>
    <div class="position">Director General</div>
  </div>

  <div class="signature-block" style="margin-top:18px;">
    <div class="signature-name">Dr. Fidel Argenis Flores Quiroz</div>
    <div class="position">Director General</div>
  </div>

  <div class="space" style="margin-top:24px; font-size:11pt;">
    <strong>No. de folio:</strong> {{ $constancia->no_folio }}
    &nbsp;&nbsp;&nbsp;
    <strong>Calificación:</strong> {{ $constancia->calificacion }}
  </div>

</main>

<footer>
  Documento expedido conforme al Reglamento del Servicio Social del Estado de México.
</footer>

</body>
</html>
