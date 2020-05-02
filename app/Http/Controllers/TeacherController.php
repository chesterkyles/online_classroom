<?php

namespace App\Http\Controllers;

use App\Teacher;

class TeacherController extends Controller
{
    public function home(Teacher $teacher)
    {
        return view('teacher.home', compact('teacher'));
    }
}
