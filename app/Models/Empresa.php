<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_empresa';
    protected $fillable = ['nombre'];

    public function constancias() {
        return $this->hasMany(Constancia::class, 'id_empresa', 'id_empresa');
    }
    public function estudiantes(): HasMany
    {
        // El segundo parámetro es la llave foránea en la tabla 'estudiantes'
        return $this->hasMany(Estudiante::class, 'id_empresa');
    }
}
