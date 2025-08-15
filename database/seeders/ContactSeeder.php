<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::create([
            'address' => '123 GDRI Street, Dhaka, Bangladesh',
            'phone' => '+8801234567890',
            'whatsapp' => '+8801234567890',
            'email' => 'info@gdri.com'
        ]);
    }
}
