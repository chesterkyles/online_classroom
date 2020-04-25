@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="alert alert-danger text-center" role="alert">
                    <strong>{{ __(' ERROR 419. ') }}</strong>
                    {{ __(' Page has expired! ') }}
                </div>

                <div class="text-center">
                    {{ __(' Click ') }}
                    <a href="{{ request()->fullUrl() }}">here</a>
                    {{ __(' to refresh page. ') }}
                </div>
            </div>
        </div>
    </div>
@endsection
