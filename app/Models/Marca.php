<?php

namespace App\Models;

use App\Models\Producto;
use App\Models\Caracteristica;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    public function productos(){
        return $this->hasMany(Producto::class);
    }

    public function caracteristicas(){
        return $this->belongsTo(Caracteristica::class);
    }

    protected $fillable = ['caracteristica_id'];
}
