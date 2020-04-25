<?php

namespace App\Http\Controllers;

use App\Teacher;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware(['verified' ,'auth', 'route.access']);

    }

    public function home(Teacher $teacher)
    {
        return view('teacher.home', compact('teacher'));
    }
}
