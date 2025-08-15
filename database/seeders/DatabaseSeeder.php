<?php

namespace Database\Seeders;


use App\Models\Districtcov;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
            DivisionSeeder::class,
            DistrictSeeder::class,
            ThanaSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            NoticeSeeder::class,
            TaskSeeder::class,
            AuthorSeeder::class,
            BlogCategorySeeder::class,
            TagSeeder::class,
            WhyGdriSeeder::class,
            ImpactStorySeeder::class,
            OurStorySeeder::class,
            PrivacySeeder::class,
            TermSeeder::class,
            LicenseSeeder::class,
            ContactSeeder::class,
            SocialSeeder::class,
            HomeAccordianSeeder::class,
            DistrictcovSeeder::class,
            BranchSeeder::class,
        ]);
    }
}
