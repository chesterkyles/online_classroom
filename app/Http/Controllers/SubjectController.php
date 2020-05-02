<?php

namespace App\Http\Controllers;

use App\Semester;
use App\Student;
use App\Subject;
use App\Teacher;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class SubjectController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Teacher $teacher
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Teacher $teacher)
    {
        $semesters = Semester::with(['subjects' => $this->subjectTeacherIdFilter($teacher)])
            ->whereHas('subjects', $this->subjectTeacherIdFilter($teacher))
            ->orderByYearThenName()
            ->take(3)
            ->get();
        return view('teacher.subject.index', compact('teacher', 'semesters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Teacher $teacher
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Teacher $teacher)
    {
        return view('teacher.subject.create', compact('teacher'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Teacher $teacher
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, Teacher $teacher)
    {
        $data = $this->validateRequest();
        $teacher->subjects()->create($this->searchOrCreateSemester($data));
        Session::flash('success', $request->name . ' class schedule has been successfully added!');
        return redirect(route('teacher.subject.index', compact('teacher')));
    }

    /**
     * Display the specified resource.
     *
     * @param Teacher $teacher
     * @param Subject $subject
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Teacher $teacher, Subject $subject)
    {
        return view('teacher.subject.show', compact('teacher', 'subject'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Teacher $teacher
     * @param Subject $subject
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Teacher $teacher, Subject $subject)
    {
        return view('teacher.subject.edit', compact('teacher', 'subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Teacher $teacher
     * @param Subject $subject
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Teacher $teacher, Subject $subject)
    {
        $data = $this->validateRequest();
        $subject->update($this->searchOrCreateSemester($data));
        Session::flash('success', $request->name . ' class schedule has been successfully updated!');
        return redirect(route('teacher.subject.index', compact('teacher')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Teacher $teacher
     * @param Subject $subject
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Teacher $teacher, Subject $subject)
    {
        Session::flash('danger', $subject->name . ' class schedule has been deleted!');
        $subject->students()->detach($subject->students);
        $subject->exams()->detach($subject->exams);
        $subject->delete();
        return redirect(route('teacher.subject.index', compact('teacher')));
    }

    public function search(Request $request, Teacher $teacher)
    {
        $class = $request->input('class');
        $semesters = Semester::with(['subjects' => $this->subjectFilter($teacher, $class)])
            ->whereHas('subjects', $this->subjectFilter($teacher, $class))
            ->orderByYearThenName()
            ->take(3)
            ->get();
        return view('teacher.subject.index', compact('teacher', 'semesters', 'class'));
    }

    public function viewAll(Teacher $teacher)
    {
        $semesters = Semester::with(['subjects' => $this->subjectTeacherIdFilter($teacher)])
            ->whereHas('subjects', $this->subjectTeacherIdFilter($teacher))
            ->orderByYearThenName()
            ->paginate(5);
        return view('teacher.subject.index', compact('teacher', 'semesters'));
    }

    public function accept(Teacher $teacher, Subject $subject, Student $student)
    {
        $subject->students()->UpdateExistingPivot($student, ['accepted' => 1]);
        return redirect(route('teacher.subject.show', compact('teacher', 'subject')));
    }

    public function acceptAll(Teacher $teacher, Subject $subject)
    {
        $subject->students()->UpdateExistingPivot($subject->students, ['accepted' => 1]);
        return redirect(route('teacher.subject.show', compact('teacher', 'subject')));
    }

    public function remove(Teacher $teacher, Subject $subject, Student $student)
    {
        $subject->students()->detach($student);
        return redirect(route('teacher.subject.show', compact('teacher', 'subject')));
    }

    public function validateRequest()
    {
        $to_slug = trim(implode(" ", array(request()->name , request()->description)));
        $slug = SlugService::createSlug(Subject::class, 'slug', $to_slug);
        request()->request->add(['slug' => $slug]);

        return request()->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string', 'max:255'],
            'schedule' => ['required', 'string'],
            'semester_name' => ['required'],
            'semester_year' => ['required'],
            'slug' => ['required', 'string'],
        ]);
    }

    protected function subjectTeacherIdFilter($teacher)
    {
        return function($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        };
    }

    protected function subjectFilter($teacher, $class)
    {
        return function($query) use ($teacher, $class) {
            $query->where('teacher_id', $teacher->id)
                  ->where('name', 'like', '%'.$class.'%');
        };
    }

    protected function searchOrCreateSemester($data)
    {
        $semester = Semester::where('name', $data['semester_name'])
            ->where('year', $data['semester_year'])
            ->get();
        if ($semester->isNotEmpty()) {
            $semester_id = $semester->pluck('id')[0];
        } else {
            $semester = Semester::create([
                'name' => $data['semester_name'],
                'year' => $data['semester_year']
            ]);
            $semester_id = $semester->id;
        }
        $data = Arr::add($data, 'semester_id', $semester_id);
        Arr::forget($data, ['semester_name','semester_year']);

        return $data;
    }


}
