@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-4">
                    <div class="card-header d-inline align-items-center py-3">
                        <strong class="ml-3 h4">{{ __('Add a Class Schedule ') }}</strong>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('teacher.subject.store', compact('teacher')) }}">
                            @csrf
                            @include('teacher.subject.form')
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@include('teacher.subject.create_edit')

