<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_empresa';
    protected $fillable = ['nombre'];

    public function constancias() {
        return $this->hasMany(Constancia::class, 'id_empresa', 'id_empresa');
    }
}
