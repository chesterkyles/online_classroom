<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Exam extends Model
{
    protected $guarded = [];

    /*todo change localize date for all possible users*/
    /*todo : server side - detect user timezone upon registering */
    /* OR client side - detect browser timezone*/
    /* add TRAIT for format dates */
    public function getCreatedAtAttribute($date)
    {
        $date =  Carbon::parse($date)->timezone('Asia/Singapore')->toDateTimeString();
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m/d/Y g:i A');

    }

    public function getUpdatedAtAttribute($date)
    {
        $date =  Carbon::parse($date)->timezone('Asia/Singapore')->toDateTimeString();
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m/d/Y g:i A');
    }

    public function getTitleNameAttribute()
    {
        return Str::title($this->name);
    }

    public function getFirstDescriptionAttribute()
    {
        return Str::ucfirst(Str::lower($this->description));
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_subject')
            ->withPivot('taken')
            ->withTimestamps();;
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_exam')
            ->withPivot('enable')
            ->withTimestamps();;
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function attachment()
    {
        return $this->morphOne(Attachment::class, 'attachmentable');
    }
}
