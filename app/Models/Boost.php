<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use \DateTimeInterface;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Boost extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $table = 'boosts';

    protected $fillable = [
        'requester_name', 
        'company_name', 
        'group', 
        'budget', 
        'program_name', 
        'target_url', 
        'program_name', 
        'boost_start', 
        'boost_end', 
        'reason', 
        'status',
        'actual_cost',
        'user_id',
        'approve_id',
        'reviewed_at',
        'approved_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'reviewed_at',
        'approved_at',
        'boost_start',
        'boost_end',
    ];

    protected $appends = [
        'reference',
    ];

    public function getBoostStartAttribute($value)
    {  
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function getBoostEndAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.datetime_format')) : null;
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.datetime_format')) : null;
    }

    public function getReviewedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.datetime_format')) : null;
    }
    
    public function getApprovedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.datetime_format')) : null;
    }

    public function getReferenceAttribute()
    {
        $file = $this->getMedia('reference')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function channels()
    {
        return $this->beLongsToMany(Channel::class);
    }

    public function user()
    {
        return $this->beLongsTo(User::class);
    }
    
    public function approve()
    {
        return $this->beLongsTo(User::class);
    }
}
