<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prioridade;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $prioridades = ['Baixa', 'Média', 'Alta', 'Crítica'];

        foreach ($prioridades as $prioridade) {
            Prioridade::firstOrCreate(['nome' => $prioridade]);
        }
        
    }
}
