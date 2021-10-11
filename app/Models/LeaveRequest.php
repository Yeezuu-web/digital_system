<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use App\Models\Employee;
use App\Models\User;
use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveRequest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "leave_requests";

    protected $fillable = [
        'commencement_date', 'resumption_date', 'no_of_day', 'reason', 'employee_id', 'leave_type_id', 'status', 'reviewed_at', 'approved_at', 'user_id'
    ];

    protected $dates = [
        'commencement_date',
        'resumption_date',
        'commencement_date',
        'reviewed_at',
        'approved_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getCommencementDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function getResumptionDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }
    
    public function employee()
    {
        return $this->beLongsTo(Employee::class);
    }

    public function leaveType()
    {
        return $this->beLongsTo(LeaveType::class);
    }

    public function user()
    {
        return $this->beLongsTo(User::class);
    }
}
