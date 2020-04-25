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

    /*todo CHANGE THIS IMPLEMENTATION */
    /* add role type? or change url user -> type */
    protected function accountType($user)
    {
        return [
            'student' => $user->student,
            'teacher' => $user->teacher,
        ];
    }

    protected function accountModel($user)
    {
        return [
            'student' => $user->student(),
            'teacher' => $user->teacher(),
        ];
    }

    public function getAccountType($user)
    {
        return $this->accountType($user)[$user->account_type];
    }

    public function getAccountModel($user)
    {
        return $this->accountModel($user)[$user->account_type];
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }
}
