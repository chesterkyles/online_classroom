<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'account_number';
    }

    public function getFullNameAttribute()
    {
        return "{$this->lastname}, {$this->firstname} ";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject')
            ->wherePivot('accepted', '=',1)
            ->withPivot('accepted')
            ->withTimestamps();
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'student_exam')
            ->withPivot('taken')
            ->withTimestamps();
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
