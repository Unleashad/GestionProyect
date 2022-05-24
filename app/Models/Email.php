<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $hidden = array('pivot', 'created_at', 'updated_at', 'cliente_id', 'id');

    public function Cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function Obra(){
        return $this->belongsToMany(Obra::class, 'obras_emails');
    }
}
