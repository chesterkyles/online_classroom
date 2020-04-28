<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $guarded = [];

    public static function nameOptions()
    {
        return [
            'First Semester',
            'Second Semester',
            'Summer',
        ];
    }

    public function getNameYearAttribute()
    {
        return "{$this->name} - {$this->year} ";
    }

    public function scopeOrderByYearThenName($query)
    {
        return $query->orderBy('year', 'desc')->orderBy('name', 'desc');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class)
            ->orderBy('name', 'asc');
    }
}
