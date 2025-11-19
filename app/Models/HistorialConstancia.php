<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialConstancia extends Model
{
    protected $table = 'historial_constancias';
    public $timestamps = false;

    protected $fillable = [
        'id_constancia',
        'id_usuario',
        'accion',
        'fecha'
    ];

    public function constancia()
    {
        return $this->belongsTo(Constancia::class, 'id_constancia');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
