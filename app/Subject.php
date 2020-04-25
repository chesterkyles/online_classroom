<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded = [];

    public function getNameDescriptionAttribute()
    {
        return "{$this->name} - {$this->description} ";
    }

    public function getNameScheduleAttribute()
    {
        return "{$this->name} - {$this->schedule} ";
    }

    public function getNameDescriptionScheduleAttribute()
    {
        return "{$this->name} - {$this->description}, {$this->schedule}";
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_subject')
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->withPivot('accepted')
            ->withTimestamps();
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'subject_exam')
            ->orderBy('created_at', 'desc')
            ->withPivot('enable')
            ->withTimestamps();
    }
}
