<?php

namespace App\Http\Controllers;

use App\Semester;
use App\Student;
use App\Subject;
use Illuminate\Http\Request;


class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['verified', 'auth', 'route.access']);
    }


    public function home(Student $student)
    {
        return view('student.home', compact('student'));
    }

    public function index(Student $student)
    {
        $student->subjects->load('teacher');
        $semesters = Semester::orderByYearThenName()
            ->whereIn('id', $student->subjects->pluck('semester_id'))
            ->get();
        return view('student.subject.index', compact('semesters', 'student'));
    }

    public function search(Request $request, Student $student)
    {
        $data = $request->input();
        $semester_id = Semester::where('name', ($data['semester_name'] ?? ''))
            ->where('year', ($data['semester_year'] ?? ''))
            ->pluck('id');
        $subjects = Subject::with(['teacher' => $this->teacherFilter($data)])
            ->whereHas('teacher', $this->teacherFilter($data))
            ->with(['students' => $this->studentFilter($student)])
            ->where('semester_id', '=', ($semester_id[0] ?? ''))
            ->where('name', 'like', '%'.($data['class'] ?? '').'%')
            ->get();
        return view('student.search', compact('student', 'data' , 'subjects'));
    }

    public function enroll(Student $student, Subject $subject)
    {
        $student->subjects()->attach($subject);
        return redirect()->back()->with('enroll_class', 'You enroll to ' . $subject->name . ' (' .
            $subject->description . '), ' . $subject->schedule . '. Please wait for confirmation and approval.');
    }

    protected function teacherFilter($data)
    {
        return function($query) use($data) {
            $query->where('firstname', 'like', '%' . ($data['teacher'] ?? '') . '%')
                ->orWhere('lastname', 'like', '%' . ($data['teacher'] ?? '') . '%');
        };
    }

    protected function studentFilter($student)
    {
        return function($query) use($student) {
            $query->where('student_id', $student->id);
        };
    }

    protected function subjectFilter($subjects)
    {
        return function($query) use ($subjects) {
            $query->where('student_id', $subjects->id);
        };
    }

}
