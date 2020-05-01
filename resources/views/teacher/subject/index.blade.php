@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
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

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb px-4 font-weight-bolder">
                        <li class="breadcrumb-item active" aria-current="page">Classes</li>
                    </ol>
                </nav>

                <div class="card">
                    <div class="card-header d-inline-block d-md-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center justify-content-center">
                            <strong class="ml-3 mr-2 mt-2 h4">{{ __('Class Schedule') }}</strong>
                            <a href="{{ route('teacher.subject.create', compact('teacher')) }}" class="btn p-0"
                               data-toggle="tooltip" title="Add a new class schedule!">
                                <span class="fa-stack">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </div>
                        @if(!Request::is('*/all'))
                            <div class="mr-3 my-2">
                                <form class="input-group justify-content-center" role="search" action="{{ route('teacher.subject.search', compact('teacher')) }}" method="GET">
                                    <div class="input-group rounded">
                                        <input type="search" name="class" class="px-2 form-control" placeholder="Course Code" value="{{ old('class') ?: $class ?? '' }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        @foreach($semesters as $semester)
                            @if($semester->subjects->isNotEmpty())
                                <div id="a-semester">
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
                                            <div class="col-5">{{ __('Description') }}</div>
                                            <div class="col-4">{{ __('Schedule') }}</div>
                                        </div>
                                    </li>
                                    <hr class="m-2 border-success">
                                    @foreach($semester->subjects as $subject)
                                    <li class="list-group-item border-0 p-0 m-0">
                                        <div class="mx-4 mb-1 align-items-center text-center text-md-left d-block d-md-flex">
                                            <div class="col-12 col-md-2">
                                                <a href="{{ route('teacher.subject.show', compact('teacher', 'subject')) }}">
                                                    {{ $subject->name }}
                                                </a>
                                            </div>
                                            <div class="col-12 col-md-5">{{ $subject->description }}</div>
                                            <div class="col-12 col-md-4">{{ $subject->schedule }}</div>
                                            <div class="col-12 col-md-1 p-0">
                                                <a href="{{ route('teacher.subject.edit', compact('teacher', 'subject')) }}"
                                                   data-toggle="tooltip" title="Edit" class="mr-2 text-decoration-none">
                                                    <i class="fa fa-edit text-info"></i>
                                                </a>
                                                <a href="#" data-toggle="modal" data-target="#delete_confirm-{{ $subject->id }}"
                                                    data-toggle="tooltip" title="Delete" class="text-decoration-none">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </a>
                                            </div>
                                            <form action="{{ route('teacher.subject.destroy', compact('teacher', 'subject')) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                @include('dialog.subject.delete')
                                            </form>
                                        </div>
                                    </li>
                                    <hr class="m-2">
                                    @endforeach
                                </ul>
                                <div class="mb-3"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @if(!Request::is('*/all'))
                    <div class="ml-4 text-muted small">{{ __('Shows only three (3) recent semesters. Click ') }}
                        <a href="{{ route('teacher.subject.viewAll', compact('teacher')) }}">
                            {{ __('here') }}
                        </a>{{ __('to view all.') }}
                    </div>
                @else
                    <div class="d-flex mt-2 mb-4 justify-content-center">{{ $semesters->links() }}</div>
                @endif

                @if(Request::is('*/search'))
                    <div class="d-block mt-2 text-center mb-4">
                        <a href="{{ route('teacher.subject.index', compact('teacher')) }}">
                            {{ __('Go back to class schedule') }}
                        </a>
                    </div>
                @endif
                <div class="mb-4"></div>
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
