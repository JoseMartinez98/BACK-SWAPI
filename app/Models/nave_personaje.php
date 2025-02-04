<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nave_personaje extends Model
{
    use HasFactory;
    protected $table = 'nave_personaje';
    protected $fillable = ['id_naves','id_personajes'];
    public $timestamps = false;
}
