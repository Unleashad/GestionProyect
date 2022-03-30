<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Obra extends Model
{
    use HasFactory;

    protected $hidden = array('cliente_id', 'created_at', 'updated_at');

    protected $fillable = [

    ];

    public function Cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function Email(){
        return $this->belongsToMany(Email::class, 'obras_emails');
    }
}
