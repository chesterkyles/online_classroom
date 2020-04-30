<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Semester;
use App\Subject;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware(['verified', 'auth', 'route.access']);
    }

    public function index(Request $request, Teacher $teacher)
    {
        $data = $request->input();
        $teacher->exams->load('subjects');
        return view('teacher.exam.index', compact('teacher', 'data'));
    }

    public function create(Teacher $teacher)
    {
        $semesters = $this->getSemester($teacher);
        return view('teacher.exam.create', compact('teacher', 'semesters'));
    }

    public function store(Request $request, Teacher $teacher)
    {
        $data = Arr::add($this->validateRequest(), 'code', Str::random(40));
        $exam = $teacher->exams()->create($data);
        $subjects = Subject::whereIn('id', $request->subjects)->get();
        $exam->subjects()->attach($subjects);
        Session::flash('success', $exam->name. ' examination has been successfully added!');
        return redirect(route('teacher.exam.show', compact('teacher', 'exam')));
    }

    public function show(Teacher $teacher, Exam $exam)
    {
        $exam->load('questions.answers');
        return view('teacher.exam.show', compact('teacher','exam'));
    }

    public function preview(Teacher $teacher, Exam $exam)
    {
        $exam->load(['questions' => $this->randomOrderQuery($exam), 'questions.answers']);
        return view('teacher.exam.preview', compact('teacher','exam'));
    }

    public function edit(Teacher $teacher, Exam $exam)
    {
        $semesters = $this->getSemester($teacher);
        return view('teacher.exam.edit', compact('teacher', 'exam', 'semesters'));
    }

    public function update(Request $request, Teacher $teacher, Exam $exam)
    {
        $exam->update($this->validateRequest());
        $subjects_detach = $exam->subjects->diff($exam->subjects->whereIn('id', $request->subjects));
        $exam->subjects()->detach($subjects_detach);
        $subjects_attach = Subject::whereIn('id', $request->subjects)->get()
            ->diff($exam->subjects->whereIn('id', $request->subjects));
        $exam->subjects()->attach($subjects_attach);
        Session::flash('success', $exam->name . ' examination has been successfully updated!');
        return redirect($request->redirect);
    }

    public function destroy(Teacher $teacher, Exam $exam)
    {
        Session::flash('danger', $exam->name . ' examination has been deleted!');
        $exam->subjects()->detach($exam->subjects);
        $exam->students()->detach($exam->students);
        $exam->delete();
        return redirect(route('teacher.exam.index', compact('teacher')));
    }

    public function viewAll(Request $request, Teacher $teacher)
    {
        $data = $request->input();
        $teacher->exams->load('subjects');
        return view('teacher.exam.all', compact('teacher', 'data'));
    }

    public function enable(Request $request, Teacher $teacher, Exam $exam, Subject $subject)
    {
        $enable = $exam->subjects->find($subject)->pivot->enable;
        $exam->subjects()->UpdateExistingPivot($subject, ['enable' => ($enable) ? 0 : 1]);
        Session::flash(($enable) ?  'danger' : 'success',
              $exam->name . ' examination has been ' . (($enable) ?  'disabled' : 'enabled') .
              ' for ' . $subject->name_schedule);
        return redirect()->back();
    }

    public function validateRequest()
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['string'],
            'instruction' => ['required', 'string'],
            'duration' => ['required'],
            'shuffle' => ['integer'],
        ]);
        $data['name'] = Str::upper($data['name']);
        return $data;
    }

    /*todo CAN BE OPTIMIZED IN THE FUTURE **/
    protected function getSemester($teacher)
    {
        return Semester::with(['subjects' => $this->subjectTeacherIdFilter($teacher)])
            ->whereHas('subjects', $this->subjectTeacherIdFilter($teacher))
            ->orderByYearThenName()
            ->get();
    }

    protected function subjectTeacherIdFilter($teacher)
    {
        return function($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        };
    }

    protected function randomOrderQuery($exam)
    {
        return function($query) use ($exam) {
            if($exam->shuffle)
                $query->inRandomOrder();
        };
    }

}
