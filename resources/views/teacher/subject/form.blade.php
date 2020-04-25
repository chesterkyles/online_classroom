<div class="form-group d-block mx-4">
    <label for="semester_id" class="text-md-right font-weight-bolder">{{ __('Semester') }}</label>
    <div class="d-flex">
        <select name="semester_name" id="semester_name" class="form-control w-75 mr-4">
            <option value="" disabled>Select semester</option>
            @foreach(\App\Semester::nameOptions() as $semester_name)
                <option value="{{ $semester_name }}" {{ $semester_name == ($subject->semester->name ?? '') ? 'selected' : '' }}>{{ $semester_name}}</option>
            @endforeach
        </select>
        <div class="input-group w-25">
            <div class="input-group-prepend d-none d-md-flex">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
            </div>
            <input placeholder="Year" id="datepicker" class="form-control"  type="text"  name="semester_year"
                   value="{{ old('semester_year') ?: $subject->semester->year ?? now()->year }}">
        </div>
    </div>
</div>

<div class="form-group d-block mx-4">
    <label for="name" class="text-md-right font-weight-bolder">{{ __('Subject/Course Code') }}</label>
    <small class="font-italic">{{ __('(e.g. ECE111)') }}</small>
    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ?: $subject->name ?? '' }}" required autofocus>
    @error('name')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group d-block mx-4">
    <label for="description" class="text-md-right font-weight-bolder">{{ __('Description') }}</label>
    <small class="font-italic">{{ __('(e.g. Introduction to Programming)') }}</small>
    <input id="description" type="text" class="form-control" name="description" value="{{ old('description') ?: $subject->description ?? ''}}" required autofocus>
    @error('description')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group d-block mx-4">
    <label for="schedule" class="text-md-right font-weight-bolder">{{ __('Class Schedule') }}</label>
    <small class="font-italic">{{ __('(e.g. MWF 7:30-8:30 AM)') }}</small>
    <input id="schedule" type="text" class="form-control" name="schedule" value="{{ old('schedule') ?: $subject->schedule ?? '' }}" required autofocus>
    @error('schedule')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group d-block">
    <div class="mx-4 mt-4">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
        <button type="button" class="btn btn-danger ml-2" data-toggle="modal" data-target="#cancel_confirm">{{ __('Cancel') }}</button>
        @include('dialog.cancel')
    </div>
</div>

