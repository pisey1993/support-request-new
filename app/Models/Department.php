<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_name',
        'head_name',
    ];

    // Define inverse relation if needed:
    // For example, users in this department
    public function users()
    {
        return $this->hasMany(User::class, 'department_id');
    }
}
