<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Question;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
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
     * @return \Illuminate\Http\Response
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
            $this->changeKeyToName($data['answer'][$question_type])
        );
        $keys = $this->getKeysFromQuestion($request, $question_type);
        foreach((array)$keys as $key) {
            $answers[$key]->update(['correct' => 1]);
        }
        return redirect(route('teacher.exam.show', compact('teacher','exam')))
            ->with('success', 'A question has been successfully added!');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
    public function changeKeyToName($array)
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

    public function getKeysFromQuestion(Request $request, $question_type)
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
