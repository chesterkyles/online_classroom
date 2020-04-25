@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="alert alert-danger text-center" role="alert">
                    <strong>{{ __(' ERROR 404. ') }}</strong>
                    {{ __(' Page Not Found! ') }}
                </div>

                <div class="text-center">
                    {{ __(' Return to  ') }}
                    <a href="{{ route('home') }}">home.</a>
                </div>
            </div>
        </div>
    </div>
@endsection
