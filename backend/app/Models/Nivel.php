<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $table = 'niveis';
    protected $fillable = ['nivel'];

    public function desenvolvedores()
    {
        return $this->hasMany(Desenvolvedor::class, 'nivel_id');
    }
}
