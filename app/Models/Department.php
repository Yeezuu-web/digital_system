<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\Employee;
use App\Models\Position;
use App\Models\LineManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $parentColumn = 'parent_id';

    protected $table = "departments";

    protected $fillable = [
        'title', 'parent_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    public function parent()
    {
        return $this->belongsTo(Department::class, $this->parentColumn);
    }

    public function children()
    {
        return $this->hasOne(Department::class, $this->parentColumn);
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function employees()
    {
        return $this->hasManyThrough(Employee::class, Position::class);
    }
    
    public function lineManager()
    {
        return $this->hasOne(LineManager::class);
    }

    public function leaveRequests()
    {
        return $this->hasManyThrough(LeaveRequest::class, [Employee::class, Position::class]);
    }
}
