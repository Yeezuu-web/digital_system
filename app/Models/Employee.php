<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use App\Models\Department;
use App\Models\LineManager;
use App\Models\LeaveRequest;
use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use SoftDeletes;
    use HasFactory;
    use BelongsToThrough;

    protected $table = "employees";

    protected $fillable = [
        'empId', 
        'first_name', 
        'last_name', 
        'gender', 
        'position_id', 
        'user_id',
        'eligible_leave',
        'leave_taken',
        'hire_date',
    ];

    protected $dates = [
        'hire_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getHireDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    // public function setHireDateAttribute($value)
    // {
    //     $this->attributes['hire_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    // }

    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.datetime_format')) : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    
    public function user()
    {
        return $this->beLongsTo(User::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function department()
    {
        return $this->belongsToThrough(Department::class, Position::class)->withTrashed('positons.deleted_at');
    }
    
    public function lineManager()
    {
        return $this->hasOne(LineManager::class);
    }
}
