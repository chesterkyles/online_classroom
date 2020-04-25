@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 d-block">
                @if (session()->has('success'))
                    <div class="alert alert-success text-center" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="row col-md-10 d-block d-lg-flex mb-4">
                <div class="card col-12 col-lg-8 p-0">
                    <div class="card-header align-items-center text-center py-4">
                        <strong class="h4">{{ $exam->name }}</strong>
                        <a href="{{ route('teacher.exam.edit', compact('teacher','exam')) }}"
                           data-toggle="tooltip" title="{{ __('') }}" class="ml-1 mr-2">
                            <i class="fa fa-edit fa-lg text-info"></i>
                        </a>
                    </div>
                    <div class="card-body mx-4">
                        <div class="row ml-1"><p class="p-0 m-0 mr-1 font-weight-bolder">{{ 'No. of Associated Classes: ' }}</p>{{ $exam->subjects->count() }}</div>
                        <div class="row ml-1"><p class="p-0 m-0 mr-1 font-weight-bolder">{{ 'No. of Questions: ' }}</p>{{ $exam->questions->count() }}</div>
                        <div class="row ml-1"><p class="p-0 m-0 mr-1 font-weight-bolder">{{ 'Duration: ' }}</p>
                            {{ ($exam->duration == 0) ? 'None' : ($exam->duration . ' minutes') }}</div>
                        <div class="row ml-1"><p class="p-0 m-0 mr-1 font-weight-bolder">{{ 'Shuffle Questions: ' }}</p>{{ (($exam->shuffle) ? 'Yes' : 'No') }}</div>
                    </div>
                </div>

                <div class="card d-flex col-12 col-lg-4 mt-2 mt-lg-0">
                    <div class="card-body d-block d-lg-flex align-items-center">
                        <div class="align-items-center d-flex d-lg-block">
                            <p class="d-none d-lg-block font-weight-bold">Menu buttons:</p>
                            <a href="{{ route('teacher.exam.question.create', compact('teacher', 'exam')) }}" class="btn btn-primary form-control mb-0 mb-lg-2 mx-1 mx-lg-0">Add Question</a>
                            <button class="btn btn-secondary form-control mb-0 mb-lg-2 mx-1 mx-lg-0">View Students</button>
                            <button class="btn btn-success form-control mb-0 mb-lg-2 mx-1 mx-lg-0">Preview Exam</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10 d-block">
                <div class="card mb-4">
                    <div class="card-body mx-4 justify-content-center">
                        <h5 class="card-title font-weight-bolder">{{ 'Instruction:  ' }}</h5>
                        <p class="card-subtitle ml-3">{!! nl2br(e($exam->instruction)) !!}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($exam->questions->isNotEmpty())
            @foreach($exam->questions as $key => $question)
                <div class="row justify-content-center">
                    <div class="col-md-10 d-block">
                        <div class="card mb-4">
                            <div class="card-header align-items-center py-3">
                                <h6 class="card-title font-weight-bolder ml-3 m-0">{{ 'Question No. ' }}{{ $key + 1 }}</h6>
                            </div>
                            <div class="card-body justify-content-center">
                                <div class="card-title ml-3">{!! $question->name !!}</div>
                                @foreach($question->answers as $answer)
                                    <div class="card-subtitle ml-4 mb-1">{{ $answer->name }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

@endsection

