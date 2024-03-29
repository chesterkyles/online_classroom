@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            @if (session()->has('notification.status'))
                <div class="alert alert-success text-center" role="alert">
                    <strong>{{ $teacher->firstname ?? '' }}.</strong> {{ session('notification.status') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 d-block d-md-flex p-0">
            <div class="col-12 col-md-8">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <strong class="ml-3 h4">{{ __('Dashboard') }}</strong>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('teacher.subject.create', compact('teacher')) }}"
                           class="btn btn-primary mx-3">
                            {{ __('Add Class Schedule') }}
                        </a>
                        <a href="{{ route('teacher.exam.create', compact('teacher')) }}"
                           class="btn btn-primary mx-3">
                            {{ __('Create Examination') }}
                        </a>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header py-3">
                        <strong class="ml-3 h4">{{ __('Recent Activities') }}</strong>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                @include('common.home.bookmark')
            </div>

        </div>
    </div>
</div>
@endsection
