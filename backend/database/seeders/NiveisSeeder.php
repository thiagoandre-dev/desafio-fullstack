<?php

namespace Database\Seeders;

use App\Models\Nivel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NiveisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveis = [
            'Estagiário',
            'Júnior',
            'Pleno',
            'Sênior',
            'Especialista'
        ];

        foreach ($niveis as $nivel) {
            Nivel::create(['nivel' => $nivel]);
        }
    }
}
