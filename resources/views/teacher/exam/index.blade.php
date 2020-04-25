@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11 d-block px-4">
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

            <div class="col-md-11 d-block d-lg-flex">
                <div class="col-12 col-lg-3 d-block">
                    <div class="card mb-4">
                        <div class="card-header h5">
                            <i class="fa fa-link mr-1"></i>{{ __('Links') }}
                        </div>

                        <div class="card-body p-0">
                            <div class="d-flex d-lg-block">
                                <a href="#last-created-exam"
                                   class="border-0 list-group-item list-group-item-action text-center text-lg-left text-primary">
                                    {{ __('Last Created Exam') }}
                                </a>
                                <a href="#pending-exams"
                                   class="border-0 list-group-item list-group-item-action text-center text-lg-left text-primary">
                                    {{ __('Pending Exams') }}
                                </a>
                                <a href="#enabled-exams"
                                   class="border-0 list-group-item list-group-item-action text-center text-lg-left text-primary">
                                    {{ __('Enabled Exams') }}
                                </a>
                                <a href="{{ route('teacher.exam.viewAll', compact('teacher')) }}"
                                   class="border-0 list-group-item list-group-item-action text-center text-lg-left text-primary">
                                    {{ __('View All Exams') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header h5">
                            <i class="fa fa-plus mr-1"></i>{{ __('New Exam') }}
                        </div>

                        <div class="card-body justify-content-center py-3">
                            <div class="d-flex p-0 m-0 text-center btn-group">
                                <a href="{{ route('teacher.exam.create', compact('teacher')) }}"
                                   class="btn btn-primary py-1">
                                    {{ __('Create') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-9 d-block">
                    <div class="card mb-4">
                        <a href="#collapse-exam" data-toggle="collapse" aria-expanded="false" aria-controls="#collapse-exam"
                           class="card-header d-inline align-items-center py-3 btn text-left shadow-none" id="last-created-exam">
                            <div class="d-flex ml-3">
                                <div class="col-6 m-0 p-0 h4">{{ __('Last Created Exam') }}</div>
                                <div class="text-right col-6 p-0" >
                                    <i class="fa fa-angle-double-up fa-lg mr-4 font-weight-bolder"></i>
                                </div>
                            </div>
                        </a>

                        <div class="card-body collapse show" id="collapse-exam">
                            <ul class="list-group">
                                @foreach($teacher->exams->take(1) as $exam)
                                    @include('teacher.exam.list')
                                    <div class="mb-2"></div>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <a href="#collapse-pending" data-toggle="collapse" aria-expanded="false" aria-controls="#collapse-pending"
                           class="card-header d-inline align-items-center py-3 btn text-left shadow-none" id="pending-exams">
                            <div class="d-flex ml-3">
                                <div class="col-6 m-0 p-0 h4">{{ __('Pending Examinations ') }}</div>
                                <div class="text-right col-6 p-0" >
                                    <i class="fa fa-angle-double-up fa-lg mr-4 font-weight-bolder"></i>
                                </div>
                            </div>
                        </a>

                        <div class="card-body collapse show" id="collapse-pending">
                            <ul class="list-group">
                                @foreach($teacher->exams->skip(1) as $exam)
                                    @if($exam->subjects->where('pivot.enable', 0)->isNotEmpty())
                                        @include('teacher.exam.list')
                                        <div class="mb-2"></div>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <a href="#collapse-enabled" data-toggle="collapse" aria-expanded="false" aria-controls="#collapse-enabled"
                           class="card-header d-inline align-items-center py-3 btn text-left shadow-none" id="enabled-exams">
                            <div class="d-flex ml-3">
                                <div class="col-6 m-0 p-0 h4">{{ __('Enabled Examinations ') }}</div>
                                <div class="text-right col-6 p-0" >
                                    <i class="fa fa-angle-double-up fa-lg mr-4 font-weight-bolder"></i>
                                </div>
                            </div>
                        </a>

                        <div class="card-body collapse show" id="collapse-enabled">
                            <ul class="list-group">
                                @foreach($teacher->exams->skip(1) as $exam)
                                    @if(!($exam->subjects->where('pivot.enable', 0)->isNotEmpty()))
                                        @include('teacher.exam.list')
                                        <div class="mb-2"></div>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="d-block mt-2 text-center mb-4">
                        <a href="{{ route('teacher.exam.viewAll', compact('teacher')) }}">
                            {{ __('View all created examinations') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('.card-header').click(function(e) {
                e.preventDefault();
                $(this).find('i').toggleClass('fa-angle-double-up fa-angle-double-down');
            });
            $('.copy-exam-code button').click(function() {
                $(this).siblings('.copy-exam-code input').select();
                document.execCommand("copy");
            });
            $('[data-toggle="popover"]').popover().on('shown.bs.popover', function () {
                setTimeout(function (a) {
                    a.popover('hide');
                }, 1000, $(this));
            });
        });
    </script>
@endsection
