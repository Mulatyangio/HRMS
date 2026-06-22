<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        if (! User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        Employee::factory()->count(48)->create();

        Employee::factory()->create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah@example.com',
            'department' => 'Engineering',
            'position' => 'Engineering Director',
            'is_department_head' => true,
        ]);

        Employee::factory()->create([
            'name' => 'Mike Chen',
            'email' => 'mike@example.com',
            'department' => 'Marketing',
            'position' => 'Marketing Director',
            'is_department_head' => true,
        ]);

        Employee::factory()->create([
            'name' => 'Emily Davis',
            'email' => 'emily@example.com',
            'department' => 'Finance',
            'position' => 'Finance Director',
            'is_department_head' => true,
        ]);

        Employee::factory()->create([
            'name' => 'James Wilson',
            'email' => 'james@example.com',
            'department' => 'Operations',
            'position' => 'Operations Director',
            'is_department_head' => true,
        ]);

        Employee::factory()->create([
            'name' => 'Lisa Brown',
            'email' => 'lisa@example.com',
            'department' => 'Human Resources',
            'position' => 'HR Director',
            'is_department_head' => true,
        ]);

        Employee::factory()->create([
            'name' => 'David Kim',
            'email' => 'david@example.com',
            'department' => 'Sales',
            'position' => 'Sales Director',
            'is_department_head' => true,
        ]);
    }
}
