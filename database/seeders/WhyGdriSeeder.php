<?php

namespace Database\Seeders;

use App\Models\WhyGdri;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WhyGdriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WhyGdri::create([
            'title' => 'At the Global Development & Research Initiative Foundation (GDRI), we are dedicated to creating transformative impact through our research and community initiatives. Our approach is built on the following core principles:',
            'description' => 'GDRI is a leading organization dedicated to research and development in various fields. Our mission is to innovate and provide solutions that benefit society as a whole. We focus on quality, integrity, and excellence in all our endeavors.',
        ]);
    }
}
