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
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class LeaveRequest extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $table = "leave_requests";

    protected $appends = [
        'attachments',
    ];

    protected $fillable = [
        'commencement_date', 'resumption_date', 'no_of_day', 'reason', 'employee_id', 'leave_type_id', 'status', 'reviewed_at', 'approved_at', 'user_id', 'cover_by'
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

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getCommencementDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setCommencementDateAttribute($value)
    {
        $this->attributes['commencement_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getResumptionDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setResumptionDateAttribute($value)
    {
        $this->attributes['resumption_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getAttachmentsAttribute()
    {
        return $this->getMedia('attachments');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    public function employee()
    {
        return $this->beLongsTo(Employee::class);
    }

    public function coverBy()
    {
        return $this->beLongsTo(Employee::class, 'cover_by');
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
