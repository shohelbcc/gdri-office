<?php

namespace Database\Seeders;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notices = [
            [
                'title' => 'Unveiling the Power of TALL Stack',
                'details' => 'Unveiling the Power of TALL Stack: A Laravel and Livewire Symphony. Unveiling the Power of TALL Stack: A Laravel and Livewire Symphony. Unveiling the Power of TALL Stack: A Laravel and Livewire Symphony',
                'published_at' => '2025-5-19',
            ],
            [
                'title' => 'Unveiling the Power of TALL Stack',
                'details' => 'Unveiling the Power of TALL Stack: A Laravel and Livewire Symphony. Unveiling the Power of TALL Stack: A Laravel and Livewire Symphony. Unveiling the Power of TALL Stack: A Laravel and Livewire Symphony',
                'published_at' => '2025-5-19',
            ],
            [
                'title' => 'Unveiling the Power of TALL Stack',
                'details' => 'Unveiling the Power of TALL Stack: A Laravel and Livewire Symphony. Unveiling the Power of TALL Stack: A Laravel and Livewire Symphony. Unveiling the Power of TALL Stack: A Laravel and Livewire Symphony',
                'published_at' => '2025-5-19',
            ],
            [
                'title' => 'Unveiling the Power of TALL Stack',
                'details' => 'Unveiling the Power of TALL Stack: A Laravel and Livewire Symphony. Unveiling the Power of TALL Stack: A Laravel and Livewire Symphony. Unveiling the Power of TALL Stack: A Laravel and Livewire Symphony',
                'published_at' => '2025-5-19',
            ],
        ];

        $users = User::whereIn('id', [3,4,5])->get();

        foreach ($notices as $notice) {
            $createdNotice = Notice::create($notice);
            foreach ($users as $user) {
                $createdNotice->users()->attach($user);
            }
        }
    }
}
