@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-4">
                    <div class="card-header d-inline align-items-center py-3">
                        <strong class="ml-3 h4">{{ __('Edit Class Schedule') }}</strong>
                        <div class="ml-3 font-italic">{{ $subject->name_description }}</div>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('teacher.subject.update', compact('teacher', 'subject')) }}">
                            @csrf
                            @method('PATCH')
                            @include('teacher.subject.form')
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@include('teacher.subject.create_edit')
