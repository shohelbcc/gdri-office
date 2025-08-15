<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            ['division_id' => 1, 'name' => 'Bogura'],
            ['division_id' => 1, 'name' => 'Chapai Nawabganj'],
            ['division_id' => 1, 'name' => 'Joypurhat'],
            ['division_id' => 1, 'name' => 'Naogaon'],
            ['division_id' => 1, 'name' => 'Natore'],
            ['division_id' => 1, 'name' => 'Pabna'],
            ['division_id' => 1, 'name' => 'Rajshahi'],
            ['division_id' => 1, 'name' => 'Sirajganj'],
            ['division_id' => 2, 'name' => 'Dinajpur'],
            ['division_id' => 2, 'name' => 'Gaibandha'],
            ['division_id' => 2, 'name' => 'Kurigram'],
            ['division_id' => 2, 'name' => 'Lalmonirhat'],
            ['division_id' => 2, 'name' => 'Nilphamari'],
            ['division_id' => 2, 'name' => 'Panchagarh'],
            ['division_id' => 2, 'name' => 'Rangpur'],
            ['division_id' => 2, 'name' => 'Thakurgaon'],
            ['division_id' => 3, 'name' => 'Jamalpur'],
            ['division_id' => 3, 'name' => 'Mymensingh'],
            ['division_id' => 3, 'name' => 'Netrokona'],
            ['division_id' => 3, 'name' => 'Sherpur'],
            ['division_id' => 4, 'name' => 'Barguna'],
            ['division_id' => 4, 'name' => 'Barishal'],
            ['division_id' => 4, 'name' => 'Bhola'],
            ['division_id' => 4, 'name' => 'Jhalokati'],
            ['division_id' => 4, 'name' => 'Patuakhali'],
            ['division_id' => 4, 'name' => 'Pirojpur'],
            ['division_id' => 5, 'name' => 'Bandarban'],
            ['division_id' => 5, 'name' => 'Brahmanbaria'],
            ['division_id' => 5, 'name' => 'Chandpur'],
            ['division_id' => 5, 'name' => 'Chattogram'],
            ['division_id' => 5, 'name' => 'Cumilla'],
            ['division_id' => 5, 'name' => "Cox's Bazar"],
            ['division_id' => 5, 'name' => 'Feni'],
            ['division_id' => 5, 'name' => 'Khagrachhari'],
            ['division_id' => 5, 'name' => 'Lakshmipur'],
            ['division_id' => 5, 'name' => 'Noakhali'],
            ['division_id' => 5, 'name' => 'Rangamati'],
            ['division_id' => 6, 'name' => 'Dhaka'],
            ['division_id' => 6, 'name' => 'Faridpur'],
            ['division_id' => 6, 'name' => 'Gazipur'],
            ['division_id' => 6, 'name' => 'Gopalganj'],
            ['division_id' => 6, 'name' => 'Kishoreganj'],
            ['division_id' => 6, 'name' => 'Madaripur'],
            ['division_id' => 6, 'name' => 'Manikganj'],
            ['division_id' => 6, 'name' => 'Munshiganj'],
            ['division_id' => 6, 'name' => 'Narayanganj'],
            ['division_id' => 6, 'name' => 'Narsingdi'],
            ['division_id' => 6, 'name' => 'Rajbari'],
            ['division_id' => 6, 'name' => 'Shariatpur'],
            ['division_id' => 6, 'name' => 'Tangail'],
            ['division_id' => 7, 'name' => 'Bagerhat'],
            ['division_id' => 7, 'name' => 'Chuadanga'],
            ['division_id' => 7, 'name' => 'Jashore'],
            ['division_id' => 7, 'name' => 'Jhenaida'],
            ['division_id' => 7, 'name' => 'Khulna'],
            ['division_id' => 7, 'name' => 'Kushtia'],
            ['division_id' => 7, 'name' => 'Magura'],
            ['division_id' => 7, 'name' => 'Meherpur'],
            ['division_id' => 7, 'name' => 'Narail'],
            ['division_id' => 7, 'name' => 'Satkhira'],
            ['division_id' => 8, 'name' => 'Habiganj'],
            ['division_id' => 8, 'name' => 'Moulvibazar'],
            ['division_id' => 8, 'name' => 'Sunamganj'],
            ['division_id' => 8, 'name' => 'Sylhet'],

        ];

        foreach ($districts as $key => $value) {
            District::create($value);
        }
    }
}
