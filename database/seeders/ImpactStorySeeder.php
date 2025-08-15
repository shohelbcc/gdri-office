<?php

namespace Database\Seeders;

use App\Models\ImpactStory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImpactStorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $immpactStories = [
            [
                'title' => 'Empowering Women, Transforming Communities:',
                'description' => "In collaboration with local NGOs, GDRI implemented a women's economic empowerment program in rural areas. By providing training in entrepreneurship, financial literacy, and vocational skills, we empowered women to start their businesses. This initiative improved their economic status and had a cascading effect on the entire community, leading to increased overall prosperity.",
                'reference' => 'Women’s Economic Empowerment Program in Rural Bangladesh (2022)',
            ],
            [
                'title' => 'Enhancing Maternal and Child Health:',
                'description' => "GDRI conducted a comprehensive study on maternal and child health in underserved regions. By identifying key healthcare gaps, we collaborated with local health authorities to implement targeted interventions. Accessible healthcare services, nutritional support, and awareness campaigns resulted in a significant reduction in maternal and child mortality rates.",
                'reference' => 'Maternal and Child Health Initiative (2023)',
            ],
            [
                'title' => 'Promoting Inclusive Education:',
                'description' => "In partnership with schools and educational organizations, GDRI launched initiatives to promote inclusive education for children with disabilities. Through teacher training, accessible learning materials, and infrastructure improvements, we created inclusive learning environments. As a result, children with disabilities gained access to quality education, fostering a more inclusive and compassionate society.",
                'reference' => 'Project Reference: Inclusive Education Program (2021)',
            ],
        ];

        foreach ($immpactStories as $story) {
            ImpactStory::create($story);
        }
    }
}
