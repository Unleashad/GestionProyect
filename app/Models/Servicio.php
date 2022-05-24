<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $hidden = array(
        'user_id', 
        'maquina_id', 
        'obra_id', 
        'created_at', 
        'updated_at'
    );

    protected $casts = [
        'email_verified_at' => 'datetime',
        'hora_ini' => 'datetime',
        'hora_fin' => 'datetime',
        'fecha' => 'date',
        'estado' => 'boolean'
    ];

    use HasFactory;

    public function Trabajador(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Obra(){
        return $this->belongsTo(Obra::class, 'obra_id');
    }

    public function Albaran(){
        return $this->hasOne(Albaran::class, 'albaran_id');
    }

    public function Maquina(){
        return $this->belongsTo(Maquina::class, 'maquina_id');
    }
}
