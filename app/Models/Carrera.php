<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_carrera';
    protected $fillable = ['nombre'];

    public function estudiantes() {
        return $this->hasMany(Estudiante::class, 'id_carrera', 'id_carrera');
    }
}
