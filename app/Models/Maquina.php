<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    protected $hidden = array('created_at', 'updated_at');

    use HasFactory;

    public function Servicio(){
        return $this->hasMany(Servicio::class);
    }
}
