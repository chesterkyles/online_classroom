<div class="modal fade" id="disable_confirm-{{ $exam->id }}-{{ $subject->id }}">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">Disable Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                {{ __('Are you sure you want to disable ') }}
                <strong class="text-danger">{{ $exam->name  }}</strong>{{ __(' examination for the class ') }}
                <strong class="text-info">{{ $subject->name_schedule }}</strong>{{ __('?') }}
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <a href="{{ route('teacher.exam.enable', compact('teacher', 'exam', 'subject')) }}" class="btn btn-primary">{{ __('Yes') }}</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('No') }}</button>
            </div>

        </div>
    </div>
</div>
