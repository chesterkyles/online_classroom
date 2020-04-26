@extends('layouts.app')

@section('head-scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 d-block">
                <div class="card mb-4">
                    <div class="card-header align-items-center py-3">
                        <strong class="ml-3 h4">{{ __('Edit Question No. ') }}{{ $key + 1 }}</strong>
                    </div>
                    <div class="card-body mx-4 justify-content-center my-3">
                        <div class="form-group">
                            <form method="POST" action="{{ route('teacher.exam.question.update', compact('teacher','exam','question')) }}">
                                @csrf
                                @method('PATCH')
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

