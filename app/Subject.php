<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Subject extends Model
{
    use Sluggable;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable()
    {
        return ['slug' => []];
    }

    public function getIsBookmarkedAttribute()
    {
        return $this->users->find(auth()->user());
    }

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

    public function posts()
    {
        return $this->hasMany(Post::class)
            ->orderBy('created_at', 'desc');
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

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_subject')
            ->withPivot('name')
            ->withTimestamps();
    }

    public function get_users(){
        $keys = $this->students->map->only(['user_id'])->flatten()->toArray();
        $users = User::whereIn('id', $keys)->get();
        if(auth()->user()->account_type == 'student'){
            $users = $users->diff(User::where('id', auth()->user()->id)->get());
            $users->push(User::where('id', $this->teacher->id)->first());
        }
        return $users;
    }
}
