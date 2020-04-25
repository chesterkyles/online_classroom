@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header align-items-center py-3">
                        <strong class="ml-3 h4">{{ __('Class Schedule') }}</strong>
                    </div>
                    <div class="card-body">
                        @foreach($semesters as $semester)
                            <div class="text-center">
                                <h5 class="font-weight-bolder my-3">{{ $semester->name . ' - ' . $semester->year }}</h5>
                            </div>
                            <hr class="m-2 d-none d-md-block border-success">
                            <div class="row mx-4 my-2 mb-1 align-items-center text-center text-md-left d-none d-md-flex font-weight-bolder">
                                <div class="col-12 col-md-2">{{ __('Code') }}</div>
                                <div class="col-12 col-md-4">{{ __('Description') }}</div>
                                <div class="col-12 col-md-3">{{ __('Schedule') }}</div>
                                <div class="col-12 col-md-3">{{ __('Teacher\'s Name') }}</div>
                            </div>
                            <hr class="m-2 border-success">
                            @foreach($student->subjects->where('semester_id', $semester->id) as $subject)
                                <a href="#" class="a-norm">
                                    <div class="row mx-4 my-2 mb-3 align-items-center text-center text-md-left d-block d-md-flex">
                                        <div class="col-12 col-md-2">{{ $subject->name }}</div>
                                        <div class="col-12 col-md-4">{{ $subject->description }}</div>
                                        <div class="col-12 col-md-3">{{ $subject->schedule }}</div>
                                        <div class="col-12 col-md-3">
                                            {{ $subject->teacher->lastname . ', ' . $subject->teacher->firstname }}
                                        </div>
                                    </div>
                                </a>
                                <hr class="m-2">
                            @endforeach
                            <div class="mb-5"></div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
