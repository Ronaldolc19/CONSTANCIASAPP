<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Periodo extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_periodo';
    protected $fillable = ['fecha_inicio','fecha_fin'];

    public function constancias() {
        return $this->hasMany(Constancia::class, 'id_periodo', 'id_periodo');
    }
    public function estudiantes(): HasMany
    {
        // Verifica que la llave foránea en la tabla estudiantes se llame 'id_periodo'
        return $this->hasMany(Estudiante::class, 'id_periodo');
    }
     public function getPeriodoFormateadoAttribute()
    {
        // Asegura que Carbon traduzca a español si tu servidor lo soporta
        Carbon::setLocale('es');
        $inicio = Carbon::parse($this->fecha_inicio)->translatedFormat('j \\d\\e F \\d\\e Y');
        $fin = Carbon::parse($this->fecha_fin)->translatedFormat('j \\d\\e F \\d\\e Y');
        return "{$inicio} al {$fin}";
    }
}
