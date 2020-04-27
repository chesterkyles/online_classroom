<div class="form-group d-block mx-4">
    <label for="name" class="text-md-right font-weight-bolder mb-0">{{ __('Name') }}</label>
    <small class="d-block font-italic mb-2 ml-2">{{ __('Provide name for the examination such as examination number, topic, lesson, etc.') }}</small>
    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ?: $exam->name ?? '' }}" style="text-transform: uppercase;" required autofocus>
    @error('name')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group d-block mx-4">
    <label for="description" class="text-md-right font-weight-bolder mb-0">{{ __('Description') }}</label>
    <small class="font-italic">{{ __('(Optional)') }} </small>
    <small class="d-block font-italic mb-2 ml-2">{{ __('Provide a concise description which may explain some details about the examination.') }}</small>
    <input id="description" type="text" class="form-control" name="description" value="{{ old('description') ?: $exam->description ?? ''}}" autofocus>
    @error('description')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group d-block mx-4">
    <label for="instruction" class="text-md-right font-weight-bolder mb-0">{{ __('Instruction') }}</label>
    <small class="d-block font-italic mb-2 ml-2">{{ __('Provide a detailed instruction or step-by-step direction for the examination.') }}</small>
    <textarea id="instruction" rows="3s" class="form-control" style="resize:none" name="instruction" required autofocus>{{ old('instruction') ?: $exam->instruction ?? '' }}</textarea>
    @error('instruction')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group d-block mx-4">
    <label for="subjects[]" class="text-md-right font-weight-bolder mb-0">{{ __('Class Schedule(s)') }}</label>
    <small class="d-block font-italic mb-2 ml-2">{{ __('Select class schedule(s) associated with the examination ') }}</small>
    <select id="subject-multiple" name="subjects[]" multiple="multiple" class="form-control" style="width: 100%" required autofocus>
        @foreach($semesters as $semester)
            @if($semester->subjects->isNotEmpty())
                <optgroup label="{{ $semester->name_year }}">
                    @foreach($semester->subjects as $subject)
                        <option value="{{ $subject->id }}" {{ (($exam ?? '') ? $exam->subjects->contains($subject) : '') ? 'selected' : '' }}>
                            {{ $subject->name_schedule }}
                        </option>
                    @endforeach
                </optgroup>
            @endif
        @endforeach
    </select>
</div>

<div class="d-block">
    <div class="mx-4 mt-3 d-flex justify-content-between">
        <div class="d-block">
            <div class="form-group">
                <label for="attachment" class="font-weight-bolder">{{ __('Attachment, if there\'s any') }}</label>
                <a href="#" id="attachment_clear" class="text-danger ml-2"data-toggle="tooltip" title="Clear File"><i class="fa fa-close"></i></a>
                <input type="file" class="form-control-file ml-3" id="attachment" name="attachment">
            </div>
            <div class="form-check align-items-center" data-toggle="tooltip" title="Shuffle Questions">
                <input class="form-check-input" type="hidden" name="shuffle" value="0">
                <input class="form-check-input" type="checkbox" id="shuffle" name="shuffle" value="1" {{ (($exam ?? '') ? $exam->shuffle == 1 : '') ? 'checked' : '' }}>
                <label class="form-check-label font-weight-bolder" for="shuffle" style="cursor: pointer">{{ __('Shuffle Questions') }}</label>
            </div>
        </div>
        <div class="d-block">
            <div class="d-flex align-items-center justify-content-end justify-content-md-start mr-2 mt-1 mt-md-2">
                <label for="duration" class="text-md-right font-weight-bolder mb-0 mr-2">{{ __('Duration:') }}</label>
                <input class="form-control w-25" name="duration" id="duration" value="{{ old('duration') ?: $exam->duration ?? '0'}}">
            </div>
            <div class="text-right text-md-left mr-2 mt-1">
                <small class="font-italic mb-0">{{ __('(in mins., 0 for no duration)') }}</small>
            </div>
        </div>

    </div>
</div>

<div class="form-group d-block">
    <div class="mx-4 mt-4">
        @if(Request::is('*/edit'))
            <input type="hidden" name="redirect" value="{{ request()->server('HTTP_REFERER') }}">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#update_confirm-{{ $exam->id }}">{{ __('Submit') }}</button>
            @include('dialog.exam.update')
        @else
            <button type="submmit" class="btn btn-primary">{{ __('Submit') }}</button>
        @endif
        <button type="button" class="btn btn-danger ml-2" data-toggle="modal" data-target="#cancel_confirm">{{ __('Cancel') }}</button>
        @include('dialog.cancel')
    </div>
</div>

