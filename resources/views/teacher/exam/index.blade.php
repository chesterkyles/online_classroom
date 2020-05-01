@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 d-block">
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

            <div class="col-lg-12 d-block d-md-flex m-0 p-0">
                <div class="col-12 col-md-3 d-block">
                    <div class="card mb-4">
                        <div class="card-header h5">
                            <i class="fa fa-link mr-1"></i>{{ __('Links') }}
                        </div>

                        <div class="card-body p-0">
                            <div class="d-flex d-md-block justify-content-center">
                                <div class="m-1 m-lg-2 d-flex">
                                    <a href="#last-created-exam" class="py-2 list-group-item list-group-item-action
                                        text-center text-md-left text-primary d-flex align-items-center">
                                        {{ __('Last Created Exam') }}
                                    </a>
                                </div>
                                <div class="m-1 m-lg-2 d-flex">
                                    <a href="#pending-exams" class="py-2 list-group-item list-group-item-action
                                        text-center text-md-left text-primary d-flex align-items-center">
                                        {{ __('Pending Exams') }}
                                    </a>
                                </div>
                                <div class="m-1 m-lg-2 d-flex">
                                    <a href="#enabled-exams" class="py-2 list-group-item list-group-item-action
                                        text-center text-md-left text-primary d-flex align-items-center">
                                        {{ __('Enabled Exams') }}
                                    </a>
                                </div>
                                <div class="m-1 m-lg-2 d-flex">
                                    <a href="{{ route('teacher.exam.viewAll', compact('teacher')) }}" class="py-2 list-group-item
                                        list-group-item-action text-center text-md-left text-primary d-flex align-items-center">
                                        {{ __('View All Exams') }}
                                    </a>
                                </div>
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

                    <div class="card mb-4">
                        <div class="card-header h5">
                            <i class="fa fa-filter mr-1"></i>{{ __('Filter') }}
                        </div>

                        <div class="card-body justify-content-center py-3">
                            <form role="search" action="" method="GET">
                                <div class="d-flex p-0 m-0 mb-3 text-center btn-group">
                                    <input type="search" name="name" class="form-control rounded" placeholder="Exam Name"
                                           value="{{ (array_key_exists('name', $data)) ? $data['name'] : '' }}">
                                </div>

                                <div class="d-flex p-0 m-0 mb-3 text-center btn-group">
                                    <input type="search" name="class" class="form-control rounded" placeholder="Course Code"
                                           value="{{ (array_key_exists('class', $data)) ? $data['class'] : '' }}">
                                </div>

                                <div class="d-flex p-0 m-0 text-center btn-group">
                                    <button type="submit" class="mx-1 btn btn-secondary">Enter</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

                <div class="col-12 col-md-9 d-block">
                    <div class="card mb-4">
                        <a href="#collapse-exam" data-toggle="collapse" aria-expanded="false" aria-controls="#collapse-exam"
                           class="card-header d-inline align-items-center py-3 btn text-left shadow-none" id="last-created-exam">
                            <div class="d-flex ml-3">
                                <div class="col-6 m-0 p-0 h4">{{ __('Last Created Exam') }}</div>
                                <div class="text-right col-6 p-0" >
                                    <i name="arrow" class="fa fa-angle-double-up fa-lg mr-3 font-weight-bolder"></i>
                                </div>
                            </div>
                        </a>

                        <div class="card-body collapse show" id="collapse-exam">
                            <ul class="list-group" id="lastCreatedList">
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
                                    <i name="arrow" class="fa fa-angle-double-up fa-lg mr-3 font-weight-bolder"></i>
                                </div>
                            </div>
                        </a>

                        <div class="card-body collapse show" id="collapse-pending">
                            <ul class="list-group" id="pendingMoreList">
                                @foreach($teacher->exams->skip(1) as $exam)
                                    @if($exam->subjects->where('pivot.enable', 0)->isNotEmpty())
                                        @include('teacher.exam.list')
                                    @endif
                                @endforeach
                            </ul>
{{--                        todo: change to AJAX JQUERY instead of loading all, load some first then request from database   --}}
                            <div class="text-center mt-2">
                                <a href="#" id="pendingMore" class="viewMore">View More</a>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <a href="#collapse-enabled" data-toggle="collapse" aria-expanded="false" aria-controls="#collapse-enabled"
                           class="card-header d-inline align-items-center py-3 btn text-left shadow-none" id="enabled-exams">
                            <div class="d-flex ml-3">
                                <div class="col-6 m-0 p-0 h4">{{ __('Enabled Examinations ') }}</div>
                                <div class="text-right col-6 p-0" >
                                    <i name="arrow" class="fa fa-angle-double-up fa-lg mr-3 font-weight-bolder"></i>
                                </div>
                            </div>
                        </a>

                        <div class="card-body collapse show" id="collapse-enabled">
                            <ul class="list-group" id="enabledMoreList">
                                @foreach($teacher->exams->skip(1) as $exam)
                                    @if(!($exam->subjects->where('pivot.enable', 0)->isNotEmpty()))
                                        @include('teacher.exam.list')
                                    @endif
                                @endforeach
                            </ul>
                            <div class="text-center mt-2">
                                <a href="#" id="enabledMore" class="viewMore">View More</a>
                            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.card-header').click(function(e) {
                e.preventDefault();
                $(this).find('i[name=arrow]').toggleClass('fa-angle-double-up fa-angle-double-down');
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

        $('a.viewMore').click(function() {
            let items = $('ul#'+ $(this).attr('id') + 'List > li:hidden');
            if(items.length > 0) {
                items.slice(0, 3).show();
                if (items.length < 3) $(this).html("");
            }
            return false;
        });
        $('ul#lastCreatedList > li:hidden').show();
        $("a.viewMore").click();

    </script>
@endsection
