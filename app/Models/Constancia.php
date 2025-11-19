<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Constancia extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_constancia';
    protected $fillable = ['no_registro','no_folio','calificacion','fecha_emision','id_estudiante','id_empresa','id_periodo','pdf_path'];

    public function estudiante(){ return $this->belongsTo(Estudiante::class,'id_estudiante','id_estudiante'); }
    public function empresa(){ return $this->belongsTo(Empresa::class,'id_empresa','id_empresa'); }
    public function periodo(){ return $this->belongsTo(Periodo::class,'id_periodo','id_periodo'); }
    public static function generarNumeroRegistro()
    {
        $clavePlantel = "15EIT0013G";
        $año = date("y");

        // Obtener todos los números existentes
        $registros = self::pluck('no_registro')->toArray();

        $maxConsecutivo = 0;

        foreach ($registros as $reg) {
            // Ejemplo: 15EIT0013G-19-202-N-NC
            $partes = explode('-', $reg);

            if (isset($partes[2]) && is_numeric($partes[2])) {
                $num = intval($partes[2]);
                if ($num > $maxConsecutivo) {
                    $maxConsecutivo = $num;
                }
            }
        }

        // El siguiente número disponible
        $nuevoConsecutivo = $maxConsecutivo + 1;

        // 3 dígitos
        $nuevoConsecutivo = str_pad($nuevoConsecutivo, 3, '0', STR_PAD_LEFT);

        return "{$clavePlantel}-{$año}-{$nuevoConsecutivo}-N-NC";
    }
    public static function generarNumeroFolio()
    {
        $prefijo = "SSTESVB";

        $folios = self::pluck('no_folio')->toArray();
        $max = 0;

        foreach ($folios as $folio) {
            // Extraer números
            $numero = intval(str_replace($prefijo, '', $folio));
            if ($numero > $max) {
                $max = $numero;
            }
        }

        // Siguiente número
        $nuevo = $max + 1;

        return $prefijo . str_pad($nuevo, 4, '0', STR_PAD_LEFT);
    }

}
