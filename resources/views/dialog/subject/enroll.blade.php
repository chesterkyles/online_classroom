<div class="modal fade" id="enroll_confirm-{{ $subject->id }}">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">Enroll Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                @if($subject->students->isNotEmpty())
                    @if($subject->students->find($student->id)->pivot->accepted)
                        <div class="d-block mb-2 text-info">
                            {{ __('You are currently enrolled to this class: ') }}
                            <strong>{{ $subject->name_description_schedule }}
                                    {{ ',Teacher: ' . $subject->teacher->first_last_name . '. '}}</strong>
                        </div>
                        <div class="d-block">{{ __('Please contact the teacher if you have any concern.') }}</div>
                    @else
                        <div class="d-block mb-2 text-danger">
                            {{ __('You have already sent an application to this class: ') }}
                            <strong>{{ $subject->name_description_schedule }}</strong>
                            {{ __(' and awaiting for confirmation and approval from your teacher.') }}
                        </div>
                        <div class="d-block">{{ __('Please wait or contact your teacher directly.') }}</div>
                    @endif
                @else
                    {{ __('Are you sure you want to enroll to this class:') }}
                    <strong>{{ $subject->name_description_schedule }}</strong>{{ __('?') }}
                @endif
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                @if($subject->students->isNotEmpty())
                    <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('OK') }}</button>
                @else
                    <a href="{{ route('student.subject.enroll', compact('student', 'subject')) }}" class="btn btn-primary">{{ __('Yes') }}</a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('No') }}</button>
                @endif
            </div>

        </div>
    </div>
</div>
