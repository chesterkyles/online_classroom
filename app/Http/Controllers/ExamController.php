<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Semester;
use App\Subject;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware(['verified', 'auth', 'route.access']);
    }

    public function index(Teacher $teacher)
    {
        $teacher->exams->load('subjects');
        return view('teacher.exam.index', compact('teacher'));
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
        return redirect(route('teacher.exam.show', compact('teacher', 'exam')))
            ->with('success', $exam->name. ' examination has been successfully added!');
    }

    public function show(Teacher $teacher, Exam $exam)
    {
        return view('teacher.exam.show', compact('teacher','exam'));
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
        return redirect($request->redirect)
            ->with('success', $exam->name . ' examination has been successfully updated!');
    }

    public function destroy(Teacher $teacher, Exam $exam)
    {
        $exam_temp = $exam->name;
        $exam->subjects()->detach($exam->subjects);
        $exam->students()->detach($exam->students);
        $exam->delete();
        return redirect(route('teacher.exam.index', compact('teacher')))
            ->with('danger', $exam_temp . ' examination has been deleted!');
    }

    public function viewAll(Teacher $teacher)
    {
        $teacher->exams->load('subjects');
        return view('teacher.exam.view', compact('teacher'));
    }

    public function enable(Teacher $teacher, Exam $exam, Subject $subject)
    {
        $enable = $exam->subjects->find($subject)->pivot->enable;
        $exam->subjects()->UpdateExistingPivot($subject, ['enable' => ($enable) ? 0 : 1]);
        $message = ($enable) ?  'disabled' : 'enabled';
        $status = ($enable) ?  'danger' : 'success';
        return redirect()->back()->with($status,
            $exam->name . ' examination has been ' . $message . ' for ' . $subject->name_schedule);
    }

    public function validateRequest()
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['max:255'],
            'instruction' => ['required', 'string', 'max:255'],
            'duration' => ['required'],
            'shuffle' => ['integer'],
        ]);
        $data['name'] = Str::upper($data['name']);
        return $data;
    }

    /** CAN BE OPTIMIZED IN THE FUTURE **/
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

}
