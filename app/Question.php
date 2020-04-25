<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function attachment()
    {
        return $this->morphOne(Attachment::class, 'attachmentable');
    }
}
