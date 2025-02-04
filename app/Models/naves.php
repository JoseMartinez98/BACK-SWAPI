<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class naves extends Model
{
    use HasFactory;
    protected $table = 'naves';
    protected $fillable = ['id_naves','name', 'model','cost_in_credits','url']; 
    public $timestamps = false;

    public function personajes()
    {
        return $this->belongsToMany(personajes::class, 'nave_personaje', 'id_naves', 'id_personajes');
    }
}
