<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Position;
use App\Models\Department;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users'; // explicitly if you're not using default

    protected $fillable = [
        'name',
        'email',
        'password',
        'view_check_request',
        'position',
        'department_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function positionRelation()
    {
        return $this->belongsTo(Position::class, 'position', 'id');
    }



}
