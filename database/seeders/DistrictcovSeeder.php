<?php

namespace Database\Seeders;

use App\Models\Districtcov;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictcovSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            ['name' => 'Bagerhat'],
            ['name' => 'Bandarban'],
            ['name' => 'Barguna'],
            ['name' => 'Barishal'],
            ['name' => 'Bhola'],
            ['name' => 'Bogura'],
            ['name' => 'Brahmanbaria'],
            ['name' => 'Chandpur'],
            ['name' => 'Chapai Nawabganj'],
            ['name' => 'Chattogram'],
            ['name' => 'Chuadanga'],
            ['name' => "Cox's Bazar"],
            ['name' => 'Cumilla'],
            ['name' => 'Dhaka'],
            ['name' => 'Dinajpur'],
            ['name' => 'Faridpur'],
            ['name' => 'Feni'],
            ['name' => 'Gaibandha'],
            ['name' => 'Gazipur'],
            ['name' => 'Gopalganj'],
            ['name' => 'Habiganj'],
            ['name' => 'Jamalpur'],
            ['name' => 'Jashore'],
            ['name' => 'Jhalokati'],
            ['name' => 'Jhenaidah'],
            ['name' => 'Joypurhat'],
            ['name' => 'Khagrachari'],
            ['name' => 'Khulna'],
            ['name' => 'Kishoreganj'],
            ['name' => 'Kurigram'],
            ['name' => 'Kushtia'],
            ['name' => 'Lakshmipur'],
            ['name' => 'Lalmonirhat'],
            ['name' => 'Madaripur'],
            ['name' => 'Magura'],
            ['name' => 'Manikganj'],
            ['name' => 'Meherpur'],
            ['name' => 'Moulvibazar'],
            ['name' => 'Munshiganj'],
            ['name' => 'Mymensingh'],
            ['name' => 'Naogaon'],
            ['name' => 'Narail'],
            ['name' => 'Narayanganj'],
            ['name' => 'Narsingdi'],
            ['name' => 'Natore'],
            ['name' => 'Netrokona'],
            ['name' => 'Nilphamari'],
            ['name' => 'Noakhali'],
            ['name' => 'Pabna'],
            ['name' => 'Patuakhali'],
            ['name' => 'Pirojpur'],
            ['name' => 'Panchagarh'],
            ['name' => 'Rajbari'],
            ['name' => 'Rajshahi'],
            ['name' => 'Rangpur'],
            ['name' => 'Rangamati'],
            ['name' => 'Satkhira'],
            ['name' => 'Shariatpur'],
            ['name' => 'Sherpur'],
            ['name' => 'Sirajgonj'],
            ['name' => 'Sunamganj'],
            ['name' => 'Sylhet'],
            ['name' => 'Tangail'],
            ['name' => 'Thakurgaon'],
        ];

        foreach ($districts as $district) {
            Districtcov::create($district);
        }
    }
}
