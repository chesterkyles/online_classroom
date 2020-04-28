<div id="toolbar">@include('teacher.exam.question.toolbar')</div>
<div id="editor-container" class="ql-container ql-snow mb-4" style="min-height: 100px; font-size:16px"></div>
<input type="hidden" name="question[name]" id="editor-content" value="{{ $question->name ?? '' }}">

<div class="row justify-content-center ql-container mb-4 border rounded p-1 py-3">
    <div class="col-12 col-lg-4 d-block d-lg-inline custom-border-right mb-2 mb-lg-0">
        <div class="tab-selector">
            <label for="questionTypeSelect" class="form-text">Question Type:</label>
            <select name="question[type]" id="questionTypeSelect" class="form-control">
                <option value="0" {{ ($question->type ?? '') == 0 ? 'selected' : '' }}>Single Answer</option>
                <option value="1" {{ ($question->type ?? '') == 1 ? 'selected' : '' }}>True or False</option>
                <option value="2" {{ ($question->type ?? '') == 2 ? 'selected' : '' }}>Multiple Choice</option>
                <option value="3" {{ ($question->type ?? '') == 3 ? 'selected' : '' }}>Multiple Response</option>
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
            <div class="tab-pane {{ ($question->type ?? '') == 0 ? 'active show' : '' }}" id="single">
                <label class="form-text text-muted">Please provide an answer:</label>
                <input type="text" name="answer[single]" id="singleAnswer" class="form-control" value="{{ $question->answers[0]->name ?? '' }}">
            </div>
            <div class="tab-pane {{ ($question->type ?? '') == 1 ? 'active show' : '' }}" id="bool">
                <label class="form-text text-muted">Please choose an option:</label>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" name="answer[bool]" id="answer_true" value="True"
                        {{ ($question->answers[0]->name ?? '') == 'True' ? 'checked' : '' }}>
                    <label class="custom-control-label" for="answer_true">{{ __('True') }}</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" name="answer[bool]" id="answer_false" value="False"
                        {{ ($question->answers[0]->name ?? '') == 'False' ? 'checked' : '' }}>
                    <label class="custom-control-label" for="answer_false">{{ __('False') }}</label>
                </div>
            </div>
            <div class="tab-pane {{ ($question->type ?? '') == 2 ? 'active show' : '' }}" id="mchoice">
                <label class="form-text text-muted">Please provide choices and choose the correct answer:</label>
                @for($i = 0; $i < 4; $i++)
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="answer[mchoiceradio]" value="{{ $i }}"
                                    {{ ($question->answers[$i]->correct ?? '') == 1 ? 'checked' : '' }}>
                            </div>
                        </div>
                        <input type="text" class="form-control" name="answer[mchoice][{{ $i }}]" value="{{ $question->answers[$i]->name ?? ''}}">
                    </div>
                @endfor
            </div>
            <div class="tab-pane {{ ($question->type ?? '') == 3 ? 'active show' : '' }}" id="mresponse">
                <label class="form-text text-muted">Please provide choices and choose the correct answers:</label>
                @for($i = 0; $i < 4; $i++)
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="checkbox" name="answer[mresponsecheckbox][{{ $i }}]" value="{{ $i }}"
                                    {{ ($question->answers[$i]->correct ?? '') == 1 ? 'checked' : '' }}>
                            </div>
                        </div>
                        <input type="text" class="form-control" name="answer[mresponse][{{ $i }}]" value="{{ $question->answers[$i]->name ?? ''}}">
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>

<div class="d-flex mb-4 align-items-center">
    <label for="points" class="form-text mr-2 m-0 p-0">{{ __('Points:') }}</label>
    <input type="text" id="question_points" name="question[points]" class="form-control"
           value="{{ $question->points ?? '' }}" style="width:5rem">
</div>

<button type="submit" id="editor-submit" class="btn btn-primary">{{ __('Submit') }}</button>
<button type="button" class="btn btn-danger ml-2" data-toggle="modal" data-target="#cancel_confirm">{{ __('Cancel') }}</button>
@include('dialog.cancel')
@include('dialog.answer')
