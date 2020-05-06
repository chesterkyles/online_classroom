<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'account_type', 'account_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'account_number';
    }

    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /*todo CHANGE THIS IMPLEMENTATION */
    /* add role type? or change url user -> type */
    public function getAccountType()
    {
        if($this->account_type == 'student') {
            return $this->student;
        } else if ($this->account_type == 'teacher') {
            return $this->teacher;
        }
    }

    public function getAccountModel()
    {
        if($this->account_type == 'student') {
            return $this->student();
        } else if ($this->account_type == 'teacher') {
            return $this->teacher();
        }
    }

    public function hasUnreadNotifs()
    {
        return ($this->unreadNotifications->count() > 0);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'user_subject')
            ->withPivot('name')
            ->withTimestamps();
    }

}
