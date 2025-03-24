<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use Illuminate\Support\Facades\Schema;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Task::truncate();
        Schema::enableForeignKeyConstraints();

        $tasks = [
            [
                'title' => 'Task 1',
                'description' => 'Description for Task 1',
                'due_date' => now()->addDays(7),
                'status' => 'To Do',
                'user_id' => 2, // Assigning the task to the second user
            ],
            [
                'title' => 'Task 2',
                'description' => 'Description for Task 2',
                'due_date' => now()->addDays(14),
                'status' => 'In Progress',
                'user_id' => 2, // Assigning the task to the second user
            ],
        ];

        // Create tasks
        foreach ($tasks as $taskData) {
            Task::create($taskData);
        }
    }
}

