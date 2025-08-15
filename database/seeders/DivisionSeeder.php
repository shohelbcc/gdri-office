<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            ['name' => 'Rajshahi'],
            ['name' => 'Rangpur'],
            ['name' => 'Mymensingh'],
            ['name' => 'Barishal'],
            ['name' => 'Chattogram'],
            ['name' => 'Dhaka'],
            ['name' => 'Khulna'],
            ['name' => 'Sylhet']
        ];

        foreach ($divisions as $key => $value) {
            Division::create($value);
        }
    }
}
