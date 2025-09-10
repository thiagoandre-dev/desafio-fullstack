<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nivel extends Model
{
    use HasFactory;

    protected $table = 'niveis';

    protected $fillable = ['nivel'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function desenvolvedores(): HasMany
    {
        return $this->hasMany(Desenvolvedor::class, 'nivel_id');
    }
}
