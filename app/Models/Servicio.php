<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    public function Trabajador(){
        return $this->belongsTo(User::class);
    }

    public function Obra(){
        return $this->belongsTo(Obra::class);
    }

    public function Albaran(){
        return $this->hasOne(Albaran::class);
    }

    public function Maquina(){
        return $this->hasOne(Maquina::class);
    }
}
