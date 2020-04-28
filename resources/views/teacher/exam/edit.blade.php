@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card mb-4">
                    <div class="card-header d-inline align-items-center py-3">
                        <strong class="ml-3 h4">{{ __(' Edit Examination ') }}</strong>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('teacher.exam.update', compact('teacher', 'exam')) }}">
                            @csrf
                            @method('PATCH')
                            @include('teacher.exam.form')
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@include('teacher.exam.create_edit')
