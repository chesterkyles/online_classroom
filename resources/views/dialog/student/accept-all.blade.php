<div class="modal fade" id="accept_all_confirm-{{ $subject->id }}">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">Accept Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                {{ __('Are you sure you want to accept all students?') }}
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <a href="{{ route('teacher.subject.acceptAll', compact('teacher', 'subject')) }}" class="btn btn-primary">{{ __('Yes') }}</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('No') }}</button>
            </div>

        </div>
    </div>
</div>
