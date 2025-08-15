<?php

namespace Database\Seeders;

use App\Models\Privacy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrivacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Privacy::create([
            'name' => 'Privacy Policy',
            'content' => '<p>This is the privacy policy for using our website...</p>',
        ]);
    }
}
