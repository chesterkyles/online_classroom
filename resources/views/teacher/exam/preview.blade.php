@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-9 d-block">
                <div class="card mb-4">
                    <div class="card-header align-items-center text-center py-3">
                        <strong class="h4">{{ $exam->name }}</strong>
                    </div>
                    <div class="card-body mx-4 justify-content-center">
                        <h5 class="card-title font-weight-bolder">{{ 'Instruction:  ' }}</h5>
                        <p class="card-subtitle ml-3">{!! nl2br(e($exam->instruction)) !!}</p>
                    </div>
                </div>
            </div>
        </div>

        @foreach($exam->questions as $key => $question)
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-9 d-block">
                    <div class="card mb-4">
                        <div class="card-header align-items-center py-3 d-flex justify-content-between">
                            <h6 class="card-title font-weight-bolder ml-3 m-0">{{ 'Question No. ' }}{{ $key + 1 }}</h6>
                        </div>
                        <div class="card-body justify-content-center">
                            <div class="card-title h6 ml-3 mt-1">{!! $question->name !!}</div>
                            <div class="mx-4 align-items-center">
                            <!-- Single Answer -->
                                @if($question->type == 0)
                                    <div class="answer_class">
                                        <input type="text" name="answer[{{ $key }}]" class="form-control" placeholder="Answer">
                                    </div>
                                @elseif($question->type == 1)
                                    <div class="answer_class">
                                        <div class="input-group my-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="radio" name="answer[{{ $key  }}]" id="true{{ $key }}"  value="True">
                                                </div>
                                            </div>
                                            <label class="form-control label-option" for="true{{ $key }}" >{{ __('True') }}</label>
                                        </div>
                                        <div class="input-group my-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="radio" name="answer[{{ $key  }}]" id="false{{ $key }}"  value="Falses">
                                                </div>
                                            </div>
                                            <label class="form-control label-option" for="false{{ $key }}">{{ __('False') }}</label>
                                        </div>
                                    </div>
                                @elseif($question->type == 2)
                                    <div class="answer_class">
                                        @foreach($question->answers as $key_ans => $answer)
                                            <div class="input-group my-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <input type="radio" name="answer[{{ $key }}]" id="mchoice{{ $key }}{{ $key_ans }}" value="{{ $key_ans }}">
                                                    </div>
                                                </div>
                                                <label class="form-control label-option" for="mchoice{{ $key }}{{ $key_ans }}">{{  $answer->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($question->type == 3)
                                    <div class="answer_class">
                                        @foreach($question->answers as $key_ans => $answer)
                                            <div class="input-group my-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <input type="checkbox" name="answer[{{ $key }}]" id="mresponse{{ $key }}{{ $key_ans }}" value="{{ $key_ans }}">
                                                    </div>
                                                </div>
                                                <label class="form-control label-option" for="mresponse{{ $key }}{{ $key_ans }}">{{  $answer->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
           $('input').on('change', function() {
               $(this).parent().closest('div[class="answer_class"]').find('input').each(function(e){
                   let $color = (this.checked) ? '#f8f9fa' : 'white';
                   $(this).parent().closest('div[class="input-group my-2"]').find('label').css('background-color', $color);
               });
           });
            $('input').on('blur', function() {
                let $color = (!$(this).val()) ? 'white' : '#f8f9fa';
                $(this).css('background-color', $color);
            });
        });
    </script>
@endsection
