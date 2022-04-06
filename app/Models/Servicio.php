<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $hidden = array('user_id', 'maquina_id', 'obra_id', 'created_at', 'updated_at');

    use HasFactory;

    public function Trabajador(){
        return $this->belongsTo(User::class, 'id');
    }

    public function Obra(){
        return $this->belongsTo(Obra::class);
    }

    public function Albaran(){
        return $this->hasOne(Albaran::class, 'id');
    }

    public function Maquina(){
        return $this->hasOne(Maquina::class, 'id');
    }
}
