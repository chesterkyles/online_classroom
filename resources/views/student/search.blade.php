@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if (session()->has('enroll_class'))
                    <div class="alert alert-info text-center" role="alert">
                        {{ session('enroll_class') }}
                    </div>
                @endif

                <div class="card mb-4">
                    <div class="card-header align-items-center py-3">
                        <strong class="ml-3 h4">{{ __('Search for a Class Schedule') }}</strong>
                    </div>
                    <form role="search" action="{{ route('student.search', compact('student')) }}" method="GET">
                        <div class="card-body d-block d-lg-flex align-items-center mx-3">
                            <div class="col-12 col-lg-6 d-flex align-items-center px-0 my-2">
                                <select name="semester_name" id="semester_name" class="pl-2 mx-1 form-control rounded">
                                    <option value="" disabled>Select semester</option>
                                    @foreach(\App\Semester::nameOptions() as $semester_name)
                                        <option value="{{ $semester_name }}" {{ $semester_name == ($data['semester_name'] ?? '') ? 'selected' : '' }}>{{ $semester_name}}</option>
                                    @endforeach
                                </select>
                                <div class="input-group w-auto h-25 mx-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input placeholder="Year" id="datepicker" class="form-control"  type="text"  name="semester_year"
                                           value="{{ (array_key_exists('semester_year', $data)) ? $data['semester_year'] : now()->year }}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-3 d-flex justify-content-center px-0 my-2">
                                <input type="search" name="teacher" class="pl-3 mx-1 form-control rounded" placeholder="Teacher's Name"
                                       value="{{ (array_key_exists('teacher', $data)) ? $data['teacher'] : '' }}">
                            </div>
                            <div class="col-12 col-lg-3 d-flex justify-content-center px-0 my-2">
                                <input type="search" name="class" class=" pl-3 mx-1 form-control rounded" placeholder="Course Code"
                                       value="{{ (array_key_exists('class', $data)) ? $data['class'] : '' }}">
                                <button type="submit" class="mx-1 btn btn-secondary"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card mb-4">
                    <div class="card-header align-items-center">
                        <strong class="ml-3 h4">{{ __('Search Result') }}</strong>
                        <label class="text-info font-weight-bolder h4"> {{ __( ' - ' . count($subjects) . ' Result(s) Found ') }} </label>
                    </div>
                    <div class="card-body">
                        @if($subjects->isNotEmpty())
                            <div class="row mx-4 my-2 mb-1 align-items-center text-center text-md-left d-none d-md-flex font-weight-bolder">
                                <div class="col-12 col-md-2">{{ __('Code') }}</div>
                                <div class="col-12 col-md-3">{{ __('Description') }}</div>
                                <div class="col-12 col-md-3">{{ __('Schedule') }}</div>
                                <div class="col-12 col-md-3">{{ __('Teacher\'s Name') }}</div>
                            </div>
                            <hr class="m-2 mb-3">
                            @foreach($subjects as $subject)
                                <div class="row mx-4 my-2 mb-3 align-items-center text-center text-md-left d-block d-md-flex">
                                    <div class="col-12 col-md-2">{{ $subject->name }}</div>
                                    <div class="col-12 col-md-3">{{ $subject->description }}</div>
                                    <div class="col-12 col-md-3">{{ $subject->schedule }}</div>
                                    <div class="col-12 col-md-3">
                                        {{ $subject->teacher->full_name }}
                                    </div>
                                    <div class="col-12 col-md-1">
                                        <a href="#" data-toggle="modal" data-target="#enroll_confirm-{{ $subject->id }}" class="btn btn-info btn-sm rounded">
                                            {{ __('Enroll') }}
                                        </a>
                                    </div>
                                    @include('dialog.subject.enroll', compact('subject'))
                                </div>
                                <hr class="m-2">
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datepicker').datepicker({
                autoclose: true,
                format: 'yyyy',
                viewMode: 'years',
                minViewMode: 'years'
            });
        });
    </script>
@endsection
