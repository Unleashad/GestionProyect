<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $hidden = array('created_at', 'updated_at');

    protected $fillable = [

    ];

    public function Obra(){
        return $this->hasMany(Obra::class);
    }

    public function Email(){
        return $this->hasMany(Email::class);
    }
}
