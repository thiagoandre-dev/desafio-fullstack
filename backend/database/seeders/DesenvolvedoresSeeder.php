<?php

namespace Database\Seeders;

use App\Models\Desenvolvedor;
use Illuminate\Database\Seeder;

class DesenvolvedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Desenvolvedor::factory()->count(50)->create();
    }
}
