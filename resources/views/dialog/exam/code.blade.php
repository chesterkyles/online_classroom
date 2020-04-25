<div class="modal fade" id="send_code-{{ $exam->id }}">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">Examination Code</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                {{ __('Here is the examination code for: ') }}
                <strong class="text-secondary text-center d-block">{{ $exam->name  }}</strong>
                <div class="copy-exam-code d-flex form-control-group my-2 justify-content-between">
                    <input class="text-info form-control mr-2" value="{{ $exam->code }}"/>
                    <button class="btn btn-light btn-sm py-0" data-toggle="popover" data-placement="top" data-content="Copied">Copy</button>
                </div>
                <hr>
                {{ __('Do you want to send the examination code to the students? ') }}
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <a href="#112" class="btn btn-primary">{{ __('Yes') }}</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('No') }}</button>
            </div>

        </div>
    </div>
</div>
