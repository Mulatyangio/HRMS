<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id',
        'month',
        'basic_salary',
        'allowances',
        'bonus',
        'overtime',
        'net_salary',
        'remarks',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
