<?php

namespace Database\Seeders;

use App\Models\HomeAccordian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeAccordianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $homeAccordians = [
            [
                'title' => 'About Us',
                'content' => 'GDRI is dedicated to improving disaster resilience through research and innovation.',
            ],
            [
                'title' => 'Our Mission',
                'content' => '<p>To empower communities by providing resources and opportunities for growth and development.</p>',
            ],
            [
                'title' => 'Get Involved',
                'content' => '<p>Join us in making a difference. Volunteer, donate, or participate in our events.</p>',
            ],
        ];

        foreach ($homeAccordians as $accordian) {
            HomeAccordian::create($accordian);
        }
    }
}
