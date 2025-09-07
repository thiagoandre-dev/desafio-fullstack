<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Desenvolvedor extends Model
{
    use HasFactory;

    protected $table = 'desenvolvedores';
    protected $fillable = ['nivel_id', 'nome', 'sexo', 'data_nascimento', 'hobby', ];
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function nivel(): BelongsTo
    {
        return $this->belongsTo(Nivel::class, 'nivel_id');
    }
}
