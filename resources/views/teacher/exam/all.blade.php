@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9 d-block d-lg-flex">
                <div class="card mb-4">
                    <div class="card-header d-inline align-items-center py-3">
                        <div class="d-flex ml-3">
                            <div class="col-6 m-0 p-0 h4">{{ __('All Examinations') }}</div>
                        </div>
                    </div>

                    <div class="card-body">
                        <ul class="list-group" id="viewAllMoreList">
                            @foreach($teacher->exams as $exam)
                                @include('teacher.exam.list')
                            @endforeach
                        </ul>
                        <div class="text-center mt-2">
                            <a href="#" id="viewAllMore" class="viewMore">View More</a>
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
            $('.copy-exam-code button').click(function() {
                $(this).siblings('.copy-exam-code input').select();
                document.execCommand("copy");
            });
            $('[data-toggle="popover"]').popover().on('shown.bs.popover', function () {
                setTimeout(function (a) {
                    a.popover('hide');
                }, 1000, $(this));
            });
            $('a.viewMore').click(function() {
                let items = $('ul#'+ $(this).attr('id') + 'List > li:hidden');
                if(items.length > 0) {
                    items.slice(0, 8).show();
                    if (items.length < 8) $(this).html("");
                }
                return false;
            });
            $("a.viewMore").click();
        });
    </script>
@endsection
