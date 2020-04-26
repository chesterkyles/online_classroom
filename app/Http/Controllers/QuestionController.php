<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Question;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class QuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['verified', 'auth', 'route.access']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Teacher $teacher
     * @param Exam $exam
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Teacher $teacher, Exam $exam)
    {
        return view('teacher.exam.question.create', compact('teacher','exam'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Teacher $teacher
     * @param Exam $exam
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, Teacher $teacher, Exam $exam)
    {
        $data = $this->validateRequest();
        $question = $exam->questions()->create($data['question']);
        $question_type = $this->questionType()[$question->type];
        $answers = $question->answers()->createMany(
            $this->changeKeysToName($data['answer'][$question_type])
        );
        $corrects = (array)$this->getCorrectAnswersFromQuestion($request, $question_type);
        foreach($corrects as $correct) {
            $answers[$correct]->update(['correct' => 1]);
        }
        Session::flash('success', 'A question has been successfully added!');
        return redirect(route('teacher.exam.show', compact('teacher','exam')));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Teacher $teacher
     * @param Exam $exam
     * @param Question $question
     * @param $key
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Teacher $teacher, Exam $exam, Question $question, $key)
    {
        return view('teacher.exam.question.edit', compact('teacher','exam','question', 'key'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Teacher $teacher
     * @param Exam $exam
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Teacher $teacher, Exam $exam, Question $question)
    {
        $data = $this->validateRequest();
        $question->update($data['question']);
        $question_type = $this->questionType()[$question->type];
        $corrects = (array)$this->getCorrectAnswersFromQuestion($request, $question_type);
        foreach($question->answers as $key => $answer) {
            $question->answers[$key]->name = $data['answer'][$question_type][$key];
            (in_array($key, $corrects)) ? $correct_value = 1 : $correct_value = 0;
            $question->answers[$key]->correct = $correct_value;
            $question->answers[$key]->save();
        }
        Session::flash('success', 'A question has been successfully updated!');
        return redirect(route('teacher.exam.show', compact('teacher','exam')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Teacher $teacher
     * @param Exam $exam
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Teacher $teacher, Exam $exam, Question $question)
    {
        $question->answers()->delete();
        $question->delete();
        Session::flash('danger', 'A question has been deleted!');
        return redirect(route('teacher.exam.show', compact('teacher','exam')));
    }


    public function validateRequest()
    {
        return request()->validate([
            'question' => ['required'],
            'answer' => ['required'],
        ]);
    }


    protected function questionType()
    {
        return [
            '0' => 'single',
            '1' => 'bool',
            '2' => 'mchoice',
            '3' => 'mresponse',
        ];
    }

    /*todo change this to a more elegant solution*/
    public function changeKeysToName($array)
    {
        $new_arr = [];
        $chunked_arr = array_chunk((array)$array,1);
        foreach($chunked_arr as $key => $value) {
            $value['name'] = $value[0];
            unset($value[0]);
            array_push($new_arr, $value);
        }
        return $new_arr;
    }

    public function getCorrectAnswersFromQuestion(Request $request, $question_type)
    {
        if($question_type == 'mchoice') {
            return $request->answer['mchoiceradio'];
        } else if($question_type == 'mresponse') {
            return $request->answer['mresponsecheckbox'];
        } else {
            return '0';
        }
    }

}
