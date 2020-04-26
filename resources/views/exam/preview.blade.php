<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-9 d-block">
            <div class="card mb-4">
                <div class="card-body mx-4 justify-content-center">
                    <h5 class="card-title font-weight-bolder">{{ 'Instruction:  ' }}</h5>
                    <p class="card-subtitle ml-3">{!! nl2br(e($exam->instruction)) !!}</p>
                </div>
            </div>
        </div>
    </div>

    @foreach($exam->questions as $key => $question)
    @endforeach
</div>
