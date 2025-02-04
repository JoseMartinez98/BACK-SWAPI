<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class personajes extends Model
{
    use HasFactory;
    protected $table = 'personajes';
    protected $fillable = ['id_personajes','name', 'gender','starships','url']; 
    public $timestamps = false;

    public function naves()
    {
        return $this->belongsToMany(naves::class, 'nave_personaje', 'id_personajes', 'id_naves');
    }
}
