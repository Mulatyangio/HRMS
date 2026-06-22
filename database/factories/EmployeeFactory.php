<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        $departments = ['Engineering', 'Marketing', 'Finance', 'Operations', 'Human Resources', 'Sales'];
        $positions = [
            'Engineering' => ['Software Engineer', 'Senior Developer', 'DevOps Engineer', 'QA Engineer', 'Tech Lead'],
            'Marketing' => ['Marketing Specialist', 'Content Writer', 'SEO Analyst', 'Brand Manager', 'Marketing Director'],
            'Finance' => ['Accountant', 'Financial Analyst', 'Controller', 'Auditor', 'CFO'],
            'Operations' => ['Operations Manager', 'Logistics Coordinator', 'Supply Chain Analyst', 'Facility Manager'],
            'Human Resources' => ['HR Coordinator', 'Recruiter', 'HR Manager', 'Training Specialist'],
            'Sales' => ['Sales Representative', 'Account Executive', 'Sales Manager', 'Business Developer'],
        ];
        $department = $this->faker->randomElement($departments);
        $position = $this->faker->randomElement($positions[$department]);

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'department' => $department,
            'position' => $position,
            'date_of_birth' => $this->faker->dateTimeBetween('-60 years', '-20 years')->format('Y-m-d'),
            'status' => $this->faker->randomElement(['active', 'active', 'active', 'active', 'on_leave']),
            'salary' => $this->faker->randomFloat(2, 40000, 180000),
            'hired_at' => $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'is_department_head' => false,
        ];
    }
}
