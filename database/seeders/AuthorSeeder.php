<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            [
                'name' => 'Author One',
                'email' => 'authorone@gmail.com',
            ],
            [
                'name' => 'Author Two',
                'email' => 'authortwo@gmail.com',
            ],
            [
                'name' => 'Author Three',
                'email' => 'authorthr@gmail.comee',
            ],
            [
                'name' => 'Author Four',
                'email' => 'authorfou@gmail.comr',
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
