<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_estudiante';
    protected $fillable = ['nombre','ap','am','genero','no_cuenta','id_carrera'];

    public function carrera() {
        return $this->belongsTo(Carrera::class, 'id_carrera', 'id_carrera');
    }

    public function constancias() {
        return $this->hasMany(Constancia::class, 'id_estudiante', 'id_estudiante');
    }
}
