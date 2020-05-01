@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb px-4 font-weight-bolder">
                        <li class="breadcrumb-item active" aria-current="page">Classes</li>
                    </ol>
                </nav>

                <div class="card">
                    <div class="card-header align-items-center py-3">
                        <strong class="ml-3 h4">{{ __('Class Schedule') }}</strong>
                    </div>
                    <div class="card-body">
                        @foreach($semesters as $semester)
                            @if($semester->subjects->isNotEmpty())
                                <div class="text-center">
                                    <a href="#collapse-sem-{{ $semester->id }}" data-toggle="collapse" aria-expanded="false"
                                       aria-controls="#collapse-sem-{{ $semester->id }}" class="d-block text-body align-items-center btn shadow-none">
                                        <div class="d-flex justify-content-between bg-light rounded-pill">
                                            <div class="text-center col-11">
                                                <h5 class="font-weight-bolder pl-4 my-2">{{ $semester->name . ' - ' . $semester->year }}</h5>
                                            </div>
                                            <div class="text-right col-1 align-self-center">
                                                <i class="fa fa-angle-double-up fa-lg mr-4 font-weight-bolder"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <ul class="list-group collapse show" id="collapse-sem-{{ $semester->id }}">
                                    <hr class="m-2 d-none d-md-block border-success">
                                    <li class="list-group-item border-0 p-0 m-0">
                                        <div class="row mx-4 font-weight-bolder d-none d-md-flex">
                                            <div class="col-2">{{ __('Code') }}</div>
                                            <div class="col-4">{{ __('Description') }}</div>
                                            <div class="col-3">{{ __('Schedule') }}</div>
                                            <div class="col-3">{{ __('Teacher\'s Name') }}</div>
                                        </div>
                                    </li>
                                    <hr class="m-2 border-success">
                                    @foreach($student->subjects->where('semester_id', $semester->id) as $subject)
                                        <a href="{{ route('student.subject.show', compact('student', 'subject')) }}" class="a-norm text-decoration-none">
                                            <li class="list-group-item border-0 p-0 m-0">
                                                <div class="row mx-4 my-2 mb-3 align-items-center text-center text-md-left d-block d-md-flex">
                                                    <div class="col-12 col-md-2">{{ $subject->name }}</div>
                                                    <div class="col-12 col-md-4">{{ $subject->description }}</div>
                                                    <div class="col-12 col-md-3">{{ $subject->schedule }}</div>
                                                    <div class="col-12 col-md-3">
                                                        {{ $subject->teacher->lastname . ', ' . $subject->teacher->firstname }}
                                                    </div>
                                                </div>
                                            </li>
                                        </a>
                                        <hr class="m-2">
                                    @endforeach
                                </ul>
                                <div class="mb-3"></div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('#a-semester a').click(function(e) {
                e.preventDefault();
                $(this).find('i').toggleClass('fa-angle-double-up fa-angle-double-down');
            });
        });
    </script>
@endsection
