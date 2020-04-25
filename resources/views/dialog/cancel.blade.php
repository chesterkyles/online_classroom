<div class="modal fade" id="cancel_confirm">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">Cancel Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                {{ __('Are you sure you want to cancel?') }}
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <a href="{{ request()->server('HTTP_REFERER') }}" class="btn btn-primary">{{ __('Yes') }}</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('No') }}</button>
            </div>

        </div>
    </div>
</div>
