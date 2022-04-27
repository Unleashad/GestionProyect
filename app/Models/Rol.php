<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $hidden = [
        "id",
        "created_at", 
        "updated_at"
    ];

    public function User()
    {
        return $this->hasMany(User::class);
    }
}
