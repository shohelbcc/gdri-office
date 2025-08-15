<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Main Office',
                'location' => 'Block-H, Plot-H/1, Floor-08, Flat-8/A, Bonosree Main Road, Dhaka-1219, Bangladesh',
                'phone' => '+880 1829520879, +8802224405838',
                'email' => 'info@gdri.org'
            ],
            [
                'name' => 'Sub-Head Office',
                'location' => 'Village:- Bisnupur, Post:- Chandkhali-9284, Sub-district:- Paikgacha, District:- Khulna, Bangladesh',
                'phone' => '+8801712442296',
                'email' => 'advsukanto@gmail.com'
            ],
            [
                'name' => 'Khulna Divisional Office',
                'location' => '2 No. Agroni Bank residential area, Gollamari Bridge, Khulna 9208',
                'phone' => '+880 1743-858279',
                'email' => 'bangkimbiswas@gmail.com'
            ],
            [
                'name' => 'Chattogram Divisional Office',
                'location' => 'Nayahat Bazar-3600, Sub-distict:- Foridgonj, District:- Chandpur, Bangladesh',
                'phone' => '+8801729971625, +880 1711-331535',
                'email' => 'dineshsarkar242@gmail.com'
            ],
            [
                'name' => 'Area Office, Khulna',
                'location' => 'Dumuria Upazila Sadar, Beside fire service, Sub-district:- Dumuria, District:- Khulna, Bangladesh',
                'phone' => '+8801741313435',
                'email' => 'uttamkumar002idri@gmail.com'
            ],
            [
                'name' => 'Area Office, Satkhira',
                'location' => 'Tala Mela Bazar, Sub-district:- Tala Upazila Sadar, District:- Satkhira, Bangladesh',
                'phone' => '+8801710540571',
                'email' => 'saifulislamsdr@gmail.com'
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}
