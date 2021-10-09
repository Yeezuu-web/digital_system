<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LineManager extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = "line_managers";

    protected $fillable = [
        'employee_id', 'department_id', 'remark'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function employee()
    {
        return $this->beLongsTo(Employee::class);
    }

    public function department()
    {
        return $this->beLongsTo(Department::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
