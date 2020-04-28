<div class="modal fade" id="open_rules" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">Examination Rules and Guidelines</h5>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <strong class="text-secondary d-block mb-2">{{ $exam->name  }}</strong>
                {{ __('Here are the rules and guidelines to follow during the examination: ') }}
                <div class="border border-info mt-2 py-2 pr-3 bg-light rounded">
                    <ol class="my-0">
                        <li>
                            Read the <b>instructions</b> carefully before answering the questions. Failure to follow these instructions may result to invalidation of the exam and worse, getting a 'zero' mark/score for the examination.
                        </li>
                        <li>
                            Check whether the examination has a <b>time duration</b>. Complete the exam within the time frame allotted and click the submit button. Otherwise, if the allotted time has elapsed, the exam will automatically close and submit your answers. Timer starts after the examination is loaded.
                        </li>
                        <li>
                            This examination can only be viewed <b class="text-danger">ONCE</b>. Do not attempt to interrupt the session by opening a new window page or other tabs. Once the exam is loaded, you are restricted to minimize or moving away from the examination window. Forcing against these restrictions may result to automatic closure and invalidation of the examination.
                        </li>
                        <li>
                            If the exam is interrupted by unforeseen circumstances, i.e problems with internet connection, window keeps on not responding, the device used has frozen, etc., try to refresh the window after the problem has resolved to see if you can return to the examination. Otherwise, contact your teacher and ask for instructions for you to follow. <i>Note: Your teacher may used his/her own discretion to let you retake the examination so make sure to avoid such circumstances to happen.</i>
                        </li>
                        <li>
                            After taking the examination, you may able to see this exam listed under 'Examination'.
                        </li>
                        <li>
                            By clicking <b>Yes</b> and proceeding to the examination window, you agree to follow the rules and guidelines provided.
                        </li>
                    </ol>
                </div>
                <hr>
                <div class="ml-4 font-italic text-danger">{{ __('Note: Contact your teacher if problems occur.') }}</div>
                <div class="ml-4">{{ __('Do you want to continue taking the exam?') }}</div>
            </div>

            <!-- Footer -->
            <div class="modal-footer justify-content-start ml-4">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="agree_rules">{{ __('Yes') }}</button>
                <a href="{{ request()->server('HTTP_REFERER') }}" class="btn btn-danger">{{ __('No') }}</a>
            </div>

        </div>
    </div>
</div>
