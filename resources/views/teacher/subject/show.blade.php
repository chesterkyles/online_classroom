@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb px-4">
                        <li class="breadcrumb-item active"><a href="{{ route('teacher.subject.index', compact('teacher')) }}">Classes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $subject->name }}</li>
                    </ol>
                </nav>

                <div class="card">
                    <div class="card-header align-items-center py-4">
                        <div class="text-center text-md-left align-items-center ml-3 mb-2">
                            <strong class="h4">{{ $subject->name_description }}</strong>
                            <a href="{{ route('teacher.subject.edit', compact('teacher', 'subject')) }}"
                               data-toggle="tooltip" title="{{ 'Edit ' . $subject->name }}" class="ml-1 mr-2">
                                <i class="fa fa-edit fa-lg text-info"></i>
                            </a>
                        </div>
                        <div class="text-center text-md-left ml-3">
                            <a href="{{ route('teacher.subject.room.index', compact('teacher', 'subject')) }}"
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
                        <div class="h6 d-flex">
                            <div class="mr-3">{{ __('Number of Students: ') }} </div>
                            <div class="text-primary">{{ $subject->students->count() }}</div>
                        </div>
                        <hr class="border-secondary mb-4">
                        <div class="col-md-12">
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-students-tab" data-toggle="tab"
                                       href="#nav-students" role="tab" aria-controls="nav-students" aria-selected="true">Students</a>
                                    <a class="nav-item nav-link" id="nav-exam-tab" data-toggle="tab"
                                       href="#nav-exam" role="tab" aria-controls="nav-exam" aria-selected="false">Examinations</a>
                                    <a class="nav-item nav-link" id="nav-extra-tab" data-toggle="tab"
                                       href="#nav-extra" role="tab" aria-controls="nav-extra" aria-selected="false">Notes</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active mt-4" id="nav-students" role="tabpanel" aria-labelledby="nav-students-tab">
                                    @if($subject->students->isNotEmpty())
                                        <hr class="my-2 mx-4 border-success">
                                        <div class="row mx-4 font-weight-bolder justify-content-center">
                                            <div class="col-3 d-none d-md-flex">{{ __('ID Number') }}</div>
                                            <div class="col-3 d-none d-md-flex">{{ __('Last Name') }}</div>
                                            <div class="col-4 d-none d-md-flex">{{ __('First Name') }}</div>
                                            <div class="col-12 justify-content-center p-0 col-md-2 d-flex">
                                                <a href="#" data-toggle="modal" data-target="#accept_all_confirm-{{ $subject->id }}"
                                                   class="btn btn-dark btn-sm rounded">
                                                    {{ __('Accept All') }}
                                                </a>
                                                @include('dialog.student.accept-all')
                                            </div>
                                        </div>
                                        <hr class="my-2 mx-4 border-success">
                                        @foreach($subject->students as $student)
                                            <div class="row mx-4 justify-content-center
                                                    align-items-center text-center text-md-left d-block d-md-flex">
                                                <div class="col-12 col-md-3">{{ $student->account_number }}</div>
                                                <div class="col-12 col-md-3">{{ $student->lastname }}</div>
                                                <div class="col-12 col-md-4">{{ $student->firstname }}</div>
                                                <div class="col-12 col-md-2 justify-content-md-between  p-0 d-block d-md-flex">
                                                    <div class="col-12 col-md-1 d-flex justify-content-center">
                                                        @if($student->pivot->accepted)
                                                            <div>
                                                                <span class="badge badge-pill badge-light">{{ __('Accepted') }}</span>
                                                            </div>
                                                        @else
                                                            <a href="{{ route('teacher.subject.accept', compact('teacher', 'subject', 'student')) }}"
                                                               class="btn btn-info btn-sm rounded">
                                                                {{ __('Accept') }}
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <div class="col-12 col-md-1 justify-content-center mt-2 mt-md-0">
                                                        <a href="#" data-toggle="modal" data-target="#delete_confirm-{{ $student->id }}"
                                                           data-toggle="tooltip" title="Delete" class="border border-danger rounded">
                                                            <i class="fa fa-trash fa-lg text-danger"></i>
                                                        </a>
                                                        @include('dialog.student.delete')
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="my-2 mx-4">
                                        @endforeach
                                    @endif
                                </div>
                                <div class="tab-pane fade mt-4" id="nav-exam" role="tabpanel" aria-labelledby="nav-exam-tab">
                                    @if($subject->exams->isNotEmpty())
                                        <hr class="my-2 mx-4 border-success d-none d-md-block">
                                        <div class="row mx-4 font-weight-bolder justify-content-center">
                                            <div class="col-8 d-none d-md-flex">{{ __('Exam Name') }}</div>
                                            <div class="col-4 d-none d-md-flex">{{ __('Creation Date and Time') }}</div>
                                        </div>
                                        <hr class="my-2 mx-4 border-success">
                                        @foreach($subject->exams as $exam)
                                            <div class="row mx-4 justify-content-center
                                                    align-items-center  d-block d-md-flex">
                                                <div class="col-12 col-md-8 d-block d-md-flex">
                                                    <div class="d-block mx-2">
                                                        <a href="{{ route('teacher.exam.show', compact('teacher', 'exam')) }}"
                                                           data-toggle="tooltip" title="Show Exam">
                                                            {{ $exam->title_name }}
                                                        </a>
                                                        @if($exam->pivot->enable)
                                                            <a href="#" data-toggle="modal" data-target="#disable_confirm-{{ $exam->id }}-{{ $subject->id }}"
                                                               data-toggle="tooltip" title="Disable Exam" class="h-25 text-decoration-none mx-2 bg-danger text-light px-3 rounded-pill">
                                                                {{ __('Disable') }}
                                                            </a>
                                                            @include('dialog.exam.disable')
                                                        @else
                                                            <a href="{{ route('teacher.exam.enable', compact('teacher', 'exam', 'subject')) }}"
                                                               data-toggle="tooltip" title="Enable Exam" class="h-25 text-decoration-none mx-2 bg-primary text-light px-3 rounded-pill">
                                                                {{ __('Enable') }}
                                                            </a>
                                                        @endif
                                                        @if(!empty($exam->description))
                                                            <div class="font-italic ml-3 text-muted">{{ $exam->first_description }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 d-block d-md-flex mt-2 mt-md-0 ml-4 ml-md-0">{{ $exam->created_at }}</div>
                                            </div>
                                            <hr class="my-2 mx-4">
                                        @endforeach
                                    @endif
                                </div>
                                <div class="tab-pane fade mt-4" id="nav-extra" role="tabpanel" aria-labelledby="nav-exam-tab">
                                    {{ __('UNDER CONSTRUCTION') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

