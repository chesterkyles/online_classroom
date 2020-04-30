@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-11 d-block d-md-flex">
                <div class="col-12 col-md-8 d-block">
                    <div class="card mb-4">
                        <div class="card-header h5">
                            {{ __('Posts') }}
                        </div>
                        <div class="card-body p-0">
                            <textarea></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 d-block">
                    <div class="card mb-4">
                        <div class="card-header h5">
                            {{ __('Events') }}
                        </div>
                        <div class="card-body p-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
