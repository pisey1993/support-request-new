<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'position',
        'ticket_no',
        'request_type',
        'requester_name',
        'project_title',
        'urgentCase',
        'purpose_of_project',
        'description_of_problem',
        'dateline_to_be_expected',
        'requested_date',
        'requested_status',
        'create_by',
        'design_detail',
        'Actual_completed_date',
        'HOD_Approval',
        'requester_department',
        'attachment1',
        'attachment2',
        'attachment3',
        'attachment4',
        'attachment5',
        'severity_description'
    ];

    protected $casts = [
        'dateline_to_be_expected' => 'datetime',
        'requested_date' => 'datetime',
        'Actual_completed_date' => 'datetime',
    ];

    // Optional relationships (if needed)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class, 'requester_department', 'id');
    }
    public function position()
    {
        return $this->belongsTo(\App\Models\Position::class, 'position', 'id');
    }
    // app/Models/SupportRequest.php

    public function subTasks()
    {
        return $this->hasMany(\App\Models\SubTask::class, 'support_request_id', 'id');
    }

}
