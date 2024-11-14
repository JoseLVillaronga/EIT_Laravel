<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('regiones')
            ->insert([
                ['nombre' => 'América de Sur'],
                ['nombre' => 'América de Central'],
                ['nombre' => 'Caribe y México'],
                ['nombre' => 'América de Norte'],
                ['nombre' => 'Europa Occidental'],
                ['nombre' => 'América del Este'],
                ['nombre' => 'Asia'],
                ['nombre' => 'Oceanía']
            ]);
    }
}
