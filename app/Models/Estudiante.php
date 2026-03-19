<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_estudiante';
    protected $fillable = [
        'nombre','ap','am','genero','no_cuenta','id_carrera',
        'id_empresa', 'id_periodo', 'no_registro', 'no_folio', 'calificacion', 'fecha_emision'];

    public function carrera() {
        return $this->belongsTo(Carrera::class, 'id_carrera', 'id_carrera');
    }
    public function empresa() 
    { 
        return $this->belongsTo(Empresa::class, 'id_empresa'); 
    }
    public function periodo()
    { 
        return $this->belongsTo(Periodo::class, 'id_periodo'); 
    }
    public function constancias() 
    {
        return $this->hasMany(Constancia::class, 'id_estudiante', 'id_estudiante');
    }
    // En app/Models/Estudiante.php

    public static function generarNumeroRegistro()
{
    $clavePlantel = "15EIT0013G";
    $año = date("y");

    // Intentamos obtener los registros; si no hay nada, el array será []
    $registros = \App\Models\Estudiante::pluck('no_registro')->toArray();

    $maxConsecutivo = 0;

    if (!empty($registros)) {
        foreach ($registros as $reg) {
            $partes = explode('-', $reg);
            if (isset($partes[2]) && is_numeric($partes[2])) {
                $num = intval($partes[2]);
                if ($num > $maxConsecutivo) $maxConsecutivo = $num;
            }
        }
    }

    // Si max es 0, el primero será 001
    $nuevoConsecutivo = str_pad($maxConsecutivo + 1, 3, '0', STR_PAD_LEFT);

    return "{$clavePlantel}-{$año}-{$nuevoConsecutivo}-N-NC";
}

public static function generarNumeroFolio()
{
    $prefijo = "SSTESVB";
    $folios = \App\Models\Estudiante::pluck('no_folio')->toArray();
    
    $max = 0;

    if (!empty($folios)) {
        foreach ($folios as $folio) {
            $numero = intval(str_replace($prefijo, '', $folio));
            if ($numero > $max) $max = $numero;
        }
    }

    // Si max es 0 (BD vacía), el primero será SSTESVB0001
    return $prefijo . str_pad($max + 1, 4, '0', STR_PAD_LEFT);
}
}
