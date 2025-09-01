<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desenvolvedor extends Model
{
    protected $table = 'desenvolvedores';
    protected $fillable = ['nivel_id', 'nome', 'sexo', 'data_nascimento', 'hobby', ];

    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'nivel_id');
    }
}
