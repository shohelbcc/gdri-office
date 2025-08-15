<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the assigner (Shohel Rana)
        $assigner = User::where('email', 'advsukanto@gmail.com')->first();

        // Get assignee users
        $mariam = User::where('email', 'mariam@gmail.com')->first();
        $sadia  = User::where('email', 'sadia@gmail.com')->first();
        $shamim1 = User::where('email', 'shamim@gmail.com')->first();
        $shamim2 = User::where('email', 'shamim9@gmail.com')->first();
        $shamim3 = User::where('email', 'shamim2@gmail.com')->first();

        // Create sample tasks and assign them

        // Task 1
        $task1 = Task::create([
            'title' => 'Prepare Project Proposal',
            'description' => 'Draft and finalize the new project proposal for client.',
            'assigned_date' => now()->toDateString(),
            'completed_date' => null,
            'priority' => 'High',
            'project' => 'Client Alpha',
            'status' => 'Started',
            'assigned_by' => $assigner->id,
        ]);

        $task1->assignees()->attach([$mariam->id, $sadia->id]);

        // Task 2
        $task2 = Task::create([
            'title' => 'Design UI Mockups',
            'description' => 'Create high fidelity mockups for the dashboard module.',
            'assigned_date' => now()->toDateString(),
            'completed_date' => null,
            'priority' => 'Medium',
            'project' => 'UI Revamp',
            'status' => 'Not Started',
            'assigned_by' => $assigner->id,
        ]);

        $task2->assignees()->attach([$shamim1->id, $shamim2->id]);

        // Task 3 - completed
        $task3 = Task::create([
            'title' => 'Fix Payment Integration Bug',
            'description' => 'Resolve PayPal integration issue reported by QA.',
            'assigned_date' => now()->subDays(5)->toDateString(),
            'completed_date' => now()->subDays(1)->toDateString(),
            'priority' => 'Critical',
            'project' => 'Ecommerce Fixes',
            'status' => 'Completed',
            'assigned_by' => $assigner->id,
        ]);

        $task3->assignees()->attach($shamim3->id);

        $this->command->info('Tasks seeded and assigned to users successfully.');
    }
}
