<?php

namespace Database\Seeders;

use App\Models\Social;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Social::create([
            'facebook' => 'https://www.facebook.com/gdri',
            'twitter' => 'https://twitter.com/gdri',
            'instagram' => 'https://www.instagram.com/gdri',
            'linkedin' => 'https://www.linkedin.com/company/gdri',
            'youtube' => 'https://www.youtube.com/c/gdri'
        ]);
    }
}
