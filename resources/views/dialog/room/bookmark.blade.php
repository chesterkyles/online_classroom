<div class="modal fade" id="bookmark-{{ $subject->id }}">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-bookmark mr-2"></i>Bookmark Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                @if($subject->is_bookmarked)
                    <div class="text-danger">{{ __('This class is already bookmarked with the name:') }}</div>
                    <p class="text-center text-danger font-weight-bolder bg-light rounded-pill my-2">
                        {{ $subject->is_bookmarked->pivot->name }}
                    </p>
                    <div class="font-weight-bolder">{{ __('Do you want to remove the bookmark?') }}</div>
                @else
                    <p class="font-weight-bolder">{{ __('Do you want to bookmark this class?') }}</p>
                    <small class="d-block my-1 text-muted text-primary">Provide a bookmark name:</small>
                    <input class="form-control" name="name" placeholder="Bookmark Name" required autofocus>
                @endif
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('No') }}</button>
            </div>

        </div>
    </div>
</div>
