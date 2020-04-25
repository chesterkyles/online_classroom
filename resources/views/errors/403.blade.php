@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="alert alert-danger text-center" role="alert">
                    <strong>{{ Auth::user()->firstname }}.</strong>
                    {{ __(' You do not have permission to view this page! ') }}
                </div>

                <div class="text-center">
                    {{ __(' Return to  ') }}
                    <a href="{{ route('home') }}">home.</a>
                </div>

            </div>
        </div>
    </div>
@endsection
