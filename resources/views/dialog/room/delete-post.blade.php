<div class="modal fade" id="delete_post_confirm-{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                {{ __('Are you sure you want to delete this post?') }}
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('No') }}</button>
            </div>

        </div>
    </div>
</div>
