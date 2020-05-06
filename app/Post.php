<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    /*todo change to Trait for code reusability*/
    public function getCreatedAtAttribute($date)
    {
        $date_tz = Carbon::parse($date)->timezone('Asia/Singapore')->toDateTimeString();
        $carbon_date = Carbon::createFromFormat('Y-m-d H:i:s', $date_tz);
        if ($carbon_date->isToday()) {
            if( Carbon::parse($date)->diffInHours(Carbon::now()) > 12 )
                return 'Today at ' . $carbon_date->format('g:i A');
            else
                return Carbon::parse($date)->diffForHumans();
        } else if ($carbon_date->isYesterday()) {
            return 'Yesterday at ' . $carbon_date->format('g:i A');
        } else {
            return $carbon_date->format('m/d/Y g:i A');
        }
    }

    public function getIsLikedAttribute()
    {
        return $this->likes->where('user_id', auth()->user()->id)->first();
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)
            ->orderBy('created_at', 'asc');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
