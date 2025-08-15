<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Category One',
                'slug' => 'category-one',
            ],
            [
                'name' => 'Category Two',
                'slug' => 'category-two',
            ],
            [
                'name' => 'Category Three',
                'slug' => 'category-three',
            ],
            [
                'name' => 'Category Four',
                'slug' => 'category-four',
            ],
        ];

        foreach ($categories as $category) {
            BlogCategory::create($category);
        }
    }
}
