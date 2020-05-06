@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            @if (session()->has('notification.status'))
                <div class="alert alert-success text-center" role="alert">
                    <strong>{{ $student->firstname ?? '' }}.</strong> {{ session('notification.status') }}
                </div>
            @endif

        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 d-block d-md-flex p-0">
            <div class="col-12 col-md-8">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <strong class="ml-3 h4">{{ __('Take Examination') }}</strong>
                    </div>
                    <div class="card-body">
                        <div class="mx-4 my-2">
                            <form class="input-group justify-content-center" role="search" action="#" method="GET">
                                <input type="text" name="class" class="px-3 form-control mr-2 rounded" placeholder="Enter Examination Code"
                                       value="{{ old('class') ?: $class ?? '' }}">
                                <button type="submit" class="btn btn-secondary">{{ __('Enter') }}</button>
                            </form>
                        </div>

                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header py-3">
                        <strong class="ml-3 h4">{{ __('Dashboard') }}</strong>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('student.search', compact('student')) }}"
                           class="btn btn-primary mx-3">
                            {{ __('Enroll Class') }}
                        </a>
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
