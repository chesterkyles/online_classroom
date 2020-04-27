@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-9 d-block">
                @if (session()->has('success'))
                    <div class="alert alert-success text-center" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session()->has('danger'))
                    <div class="alert alert-danger text-center" role="alert">
                        {{ session('danger') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="row col-md-10 col-lg-9  d-block d-lg-flex mb-4">
                <div class="card col-12 col-lg-8 p-0">
                    <div class="card-header align-items-center text-center py-3">
                        <strong class="h4">{{ $exam->name }}</strong>
                        <a href="{{ route('teacher.exam.edit', compact('teacher','exam')) }}"
                           data-toggle="tooltip" title="{{ __('') }}" class="ml-1 mr-2">
                            <i class="fa fa-edit fa-lg text-info"></i>
                        </a>
                    </div>
                    <div class="card-body mx-4">
                        <div class="row ml-1 align-items-center">
                            <p class="p-0 m-0 mr-1 font-weight-bolder">{{ 'No. of Associated Classes: ' }}</p>
                            <span class="badge badge-pill badge-primary">{{ $exam->subjects->count() }}</span>
                        </div>
                        @foreach($exam->subjects as $subject)
                            <div class="row ml-3 align-items-center text-muted">
                                <a href="{{ route('teacher.subject.show', compact('teacher', 'subject')) }}"
                                    class="text-decoration-none">
                                    {{ $subject->name_schedule }}
                                </a>
                            </div>
                        @endforeach
                        <div class="row ml-1 align-items-center">
                            <p class="p-0 m-0 mr-1 font-weight-bolder">{{ 'No. of Questions: ' }}</p>
                            <span class="badge badge-pill badge-primary">{{ $exam->questions->count() }}</span>
                        </div>
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
                            <a href="{{ route('teacher.exam.preview', compact('teacher', 'exam')) }}" class="btn btn-success form-control mb-0 mb-lg-2 mx-1 mx-lg-0">Preview Exam</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-9 d-block">
                <div class="card mb-4">
                    <div class="card-body mx-4 justify-content-center">
                        <h5 class="card-title font-weight-bolder">{{ 'Instruction:  ' }}</h5>
                        <p class="card-subtitle ml-3">{!! nl2br(e($exam->instruction)) !!}</p>
                    </div>
                </div>
            </div>
        </div>

        @foreach($exam->questions as $key => $question)
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-9 d-block">
                    <div class="card mb-4">
                        <div class="card-header align-items-center py-3 d-flex justify-content-between">
                            <h6 class="card-title font-weight-bolder ml-3 m-0">{{ 'Question No. ' }}{{ $key + 1 }}</h6>
                            <div class="mr-3">
                                <a href="{{ route('teacher.exam.question.edit', compact('teacher', 'exam', 'question', 'key')) }}"
                                   data-toggle="tooltip" title="Edit" class="mr-4 text-decoration-none">
                                    <i class="fa fa-edit fa-lg text-info"></i>
                                </a>

                                <a href="#" data-toggle="modal" data-target="#delete_confirm-{{ $question->id }}"
                                   data-toggle="tooltip" title="Delete" class="text-decoration-none">
                                    <i class="fa fa-trash fa-lg text-danger"></i>
                                </a>
                                <form action="{{ route('teacher.exam.question.destroy', compact('teacher', 'exam','question')) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    @include('dialog.question.delete')
                                </form>
                            </div>
                        </div>
                        <div class="card-body justify-content-center">
                            <div class="card-title h6 ml-3 mt-1">{!! $question->name !!}</div>
                            @foreach($question->answers as $answer)
                                <div class="d-flex align-items-center">
                                    <div class="ml-5">{{ $answer->name }}</div>
                                    @if($answer->correct == 1 )
                                        <i class="fa fa-check ml-2 text-danger"></i>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="mb-4"></div>
    </div>

@endsection

