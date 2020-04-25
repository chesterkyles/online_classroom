@extends('layouts.app')

@section('head-scripts')
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 d-block">
                <div class="card mb-4">
                    <div class="card-header align-items-center py-3">
                        <strong class="ml-3 h4">{{ __('Question No. ') }}{{ $exam->questions->count() + 1 }}</strong>
                    </div>
                    <div class="card-body mx-4 justify-content-center my-3">
                        <div class="form-group">
                            <div id="toolbar">
                                @include('teacher.exam.question.toolbar')
                            </div>

                            <div id="editor-container" class="ql-container ql-snow mb-4" style="min-height: 100px"></div>

                            <form method="POST" action="{{ route('teacher.exam.question.store', compact('teacher','exam')) }}">
                                @csrf
                                <div class="row justify-content-center ql-container mb-4 border rounded p-1 py-3">
                                    @include('teacher.exam.question.choices')
                                </div>
                                <input type="hidden" name="question[name]" id="editor-content">
                                <div class="d-flex mb-4 align-items-center">
                                    <label for="points" class="form-text mr-2 m-0 p-0">{{ __('Points:') }}</label>
                                    <input type="text" id="question_points" name="question[points]" class="form-control" style="width:5rem">
                                </div>
                                <button type="submit" id="editor-submit" class="btn btn-primary">{{ __('Submit') }}</button>
                                <button type="button" class="btn btn-danger ml-2" data-toggle="modal" data-target="#cancel_confirm">{{ __('Cancel') }}</button>
                                @include('dialog.cancel')
                                @include('dialog.answer')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.js"></script>
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
    @include('teacher.exam.question.jquery')
@endsection
