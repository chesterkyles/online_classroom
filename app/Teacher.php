<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
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

    public function getFirstLastNameAttribute()
    {
        return "{$this->lastname}, {$this->firstname} ";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class)
            ->orderBy('created_at', 'desc');
    }
}
