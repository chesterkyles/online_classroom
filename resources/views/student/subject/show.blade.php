@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb px-4">
                        <li class="breadcrumb-item active"><a href="{{ route('student.subject.index', compact('student')) }}">Classes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $subject->name }}</li>
                    </ol>
                </nav>

                <div class="card">
                    <div class="card-header align-items-center py-4">
                        <div class="text-center text-md-left align-items-center ml-3 mb-2">
                            <strong class="h4">{{ $subject->name_description }}</strong>
                        </div>
                        <div class="text-center text-md-left ml-3">
                            <a href="{{ route('classroom.index', compact('subject')) }}"
                               class="btn btn-warning rounded-pill shadow-sm">{{ __('Online Classroom') }}</a>
                        </div>
                    </div>
                    <div class="card-body mx-4 justify-content-center mb-4">
                        <div class="h6 d-flex">
                            <div class="mr-3">{{ __('Semester: ') }} </div>
                            <div class="text-primary">{{ $subject->semester->name_year }}</div>
                        </div>
                        <div class="h6 d-flex">
                            <div class="mr-3">{{ __('Schedule: ') }} </div>
                            <div class="text-primary">{{ $subject->schedule }}</div>
                        </div>
                        <hr class="border-secondary mb-4">
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

