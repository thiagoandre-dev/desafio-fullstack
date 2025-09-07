<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;

    protected $table = 'niveis';

    protected $fillable = ['nivel'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function desenvolvedores()
    {
        return $this->hasMany(Desenvolvedor::class, 'nivel_id');
    }
}
