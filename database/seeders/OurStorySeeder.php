<?php

namespace Database\Seeders;

use App\Models\OurStory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OurStorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OurStory::create([
            'description' => 'Founded in 2009 by a passionate group of researchers and development practitioners, the Global Development & Research Initiative Foundation (GDRI) stands as a beacon of change. Our mission is clear: to conduct high-quality research that not only transforms the landscape of Bangladesh but also contributes significantly to the development of other countries facing similar challenges.',
        ]);
    }
}
