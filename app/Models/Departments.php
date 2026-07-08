<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $fillable = [
        'name',
        'code',
        'head',
    ];
    public function employees()
{
    return $this->hasMany(Employee::class);
}

public function manager()
{
    return $this->belongsTo(Employee::class, 'manager_id');
}
}
