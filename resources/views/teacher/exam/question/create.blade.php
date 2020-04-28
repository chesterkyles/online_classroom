@extends('layouts.app')

@section('head-scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 d-block">
                <div class="card mb-4">
                    <div class="card-header align-items-center py-3">
                        <strong class="ml-3 h4">{{ __('Question No. ') }}{{ $exam->questions->count() + 1 }}</strong>
                    </div>
                    <div class="card-body mx-4 justify-content-center my-3">
                        <div class="form-group">
                            <form method="POST" action="{{ route('teacher.exam.question.store', compact('teacher','exam')) }}">
                                @csrf
                                @include('teacher.exam.question.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@include('teacher.exam.question.jquery')

