<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = "positions";

    protected $fillable = [
        'title', 'department_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.datetime_format')) : null;
    }

    public function department()
    {
        return $this->beLongsTo(Department::class);
    }

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
