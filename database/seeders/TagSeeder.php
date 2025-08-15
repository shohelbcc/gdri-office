<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'name' => 'Tag One',
                'slug' => 'tag-one',
            ],
            [
                'name' => 'Tag Two',
                'slug' => 'tag-two',
            ],
            [
                'name' => 'Tag Three',
                'slug' => 'tag-three',
            ],
            [
                'name' => 'Tag Four',
                'slug' => 'tag-four',
            ],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
