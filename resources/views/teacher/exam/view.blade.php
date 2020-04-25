@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 d-block d-lg-flex">
                <div class="col-12 col-lg-3 d-block">
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
                        <a href="#collapse-all-exam" data-toggle="collapse" aria-expanded="false" aria-controls="#collapse-all-exam"
                           class="card-header d-inline align-items-center py-3 btn text-left shadow-none">
                            <div class="d-flex ml-3">
                                <div class="col-6 m-0 p-0 h4">{{ __('All Examinations') }}</div>
                                <div class="text-right col-6 p-0" >
                                    <i class="fa fa-angle-double-up fa-lg mr-4 font-weight-bolder"></i>
                                </div>
                            </div>
                        </a>

                        <div class="card-body collapse show" id="collapse-all-exam">
                            <ul class="list-group">
                                @foreach($teacher->exams as $exam)
                                    @include('teacher.exam.list')
                                    <div class="mb-2"></div>
                                @endforeach
                            </ul>
                        </div>
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
