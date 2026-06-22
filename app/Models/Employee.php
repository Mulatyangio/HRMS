<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'department',
        'position',
        'date_of_birth',
        'status',
        'salary',
        'hired_at',
        'is_department_head',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'hired_at' => 'date',
            'salary' => 'decimal:2',
            'is_department_head' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOnLeave($query)
    {
        return $query->where('status', 'on_leave');
    }
}
