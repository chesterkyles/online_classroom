<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    public function getCreatedAtAttribute($date)
    {
        $date_tz = Carbon::parse($date)->timezone('Asia/Singapore')->toDateTimeString();
        $carbon_date = Carbon::createFromFormat('Y-m-d H:i:s', $date_tz);
        if ($carbon_date->isToday()) {
            return 'Today at ' . $carbon_date->format('g:i A');
        } else if ($carbon_date->isYesterday()) {
            return 'Yesterday at ' . $carbon_date->format('g:i A');
        } else {
            return $carbon_date->format('m/d/Y g:i A');
        }
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
