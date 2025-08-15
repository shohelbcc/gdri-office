<?php

namespace Database\Seeders;

use App\Models\License;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        License::create([
            'name' => 'License Agreement',
            'content' => '<p>This is the license agreement for using our website...</p>',
        ]);
    }
}
