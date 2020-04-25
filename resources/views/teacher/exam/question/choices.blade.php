<div class="col-12 col-lg-4 d-block d-lg-inline custom-border-right mb-2 mb-lg-0">
    <div class="tab-selector">
        <label for="questionTypeSelect" class="form-text">Question Type:</label>
        <select name="question[type]" id="questionTypeSelect" class="form-control">
            <option value="0">Single Answer</option>
            <option value="1">True or False</option>
            <option value="2">Multiple Choice</option>
            <option value="3">Multiple Response</option>
        </select>

        <ul class="nav nav-tabs" id="questionTypeOption" style="display:none">
            <li class="active"><a href="#single">Single Answer</a></li>
            <li><a href="#bool">True or False</a></li>
            <li><a href="#mchoice">Multiple Choice</a></li>
            <li><a href="#mresponse">Multiple Response</a></li>
        </ul>
    </div>

</div>
<div class="col-12 col-lg-8 d-block d-lg-inline mb-2">
    <div class="tab-content">
        <div class="tab-pane fade show active" id="single">
            <label for="singleAnswer" class="form-text text-muted">Please provide an answer:</label>
            <input type="text" name="answer[single]" id="singleAnswer" class="form-control">
        </div>
        <div class="tab-pane fade" id="bool">
            <label for="trueOrFalse" class="form-text text-muted">Please choose an option:</label>
            <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="answer[bool]" id="answer_true" value="True">
                <label class="custom-control-label" for="answer_true">{{ __('True') }}</label>
            </div>
            <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="answer[bool]" id="answer_false" value="False">
                <label class="custom-control-label" for="answer_false">{{ __('False') }}</label>
            </div>
        </div>
        <div class="tab-pane fade" id="mchoice">
            <label for="multipleChoicesAnswers" class="form-text text-muted">Please provide choices and choose the correct answer:</label>
            @for($i = 0; $i < 4; $i++)
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="radio" name="answer[mchoiceradio]" value="{{ $i }}">
                        </div>
                    </div>
                    <input type="text" class="form-control" name="answer[mchoice][{{ $i }}]">
                </div>
            @endfor
        </div>
        <div class="tab-pane fade" id="mresponse">
            <label for="multipleResponsesAnswers" class="form-text text-muted">Please provide choices and choose the correct answers:</label>
            @for($i = 0; $i < 4; $i++)
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" name="answer[mresponsecheckbox][{{ $i }}]" value="{{ $i }}">
                        </div>
                    </div>
                    <input type="text" class="form-control" name="answer[mresponse][{{ $i }}]">
                </div>
            @endfor
        </div>
    </div>
</div>
