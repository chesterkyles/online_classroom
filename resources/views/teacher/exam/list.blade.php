<li class="list-group-item mx-2 rounded border-0 p-0" style="display:none">
    <div class="d-block d-lg-flex justify-content-between align-items-center my-1 p-2 py-4 rounded border">
        <div class="d-block col-12" id="exam-menu-hover">
            <div class="row d-block d-lg-flex justify-content-between">
                <div class="col-12 col-lg-9 h5 font-weight-bold mb-2">
                    <a href="{{ route('teacher.exam.show', compact('teacher', 'exam')) }}" class="text-decoration-none text-secondary"
                        data-toggle="tooltip" title="Show Exam">
                        {{ $exam->name }}
                    </a>
                </div>

                <div class="col-12 col-lg-3 mb-2 mb-lg-0 align-self-start justify-content-start justify-content-lg-end" id="exam-menu-show">
                    <a href="#" data-toggle="modal" data-target="#send_code-{{ $exam->id }}"
                       data-toggle="tooltip" title="Exam Code" class="text-decoration-none mr-4 bg-secondary text-light px-3 rounded-pill">
                        {{ __('Code') }}
                    </a>
                    <a href="{{ route('teacher.exam.edit', compact('teacher', 'exam')) }}"
                       data-toggle="tooltip" title="Edit" class="mr-4 text-decoration-none">
                        <i class="fa fa-edit fa-lg text-info"></i>
                    </a>
                    <a href="#" data-toggle="modal" data-target="#delete_confirm-{{ $exam->id }}"
                       data-toggle="tooltip" title="Delete">
                        <i class="fa fa-trash fa-lg text-danger"></i>
                    </a>
                </div>
            </div>
            <div class="row d-block text-secondary ml-2">{{ 'Created at: ' . $exam->created_at }}</div>
            @if ((\Carbon\Carbon::parse($exam->updated_at))->gt(\Carbon\Carbon::parse($exam->created_at)))
                <div class="row d-block text-muted text-secondary ml-2">{{ 'Last updated on: ' . $exam->updated_at }}</div>
            @endif
            @if(!empty($exam->description))
                <div class="row font-italic ml-2">{{ 'Description: ' . $exam->description }}</div>
            @endif
            <div class="row d-block ml-2 mb-1">
                <p class="font-italic m-0">{{ 'Class Schedule(s):' }}</p>
                @foreach($exam->subjects as $subject)
                    <div class="d-flex mb-1">
                        <a href="{{ route('teacher.subject.show', compact('teacher', 'subject')) }}" class="text-decoration-none">
                            <div class="text-primary mx-4 font-weight-bolder">{{ $subject->name_schedule }}</div>
                        </a>
                        @if($subject->pivot->enable)
                            <a href="#" data-toggle="modal" data-target="#disable_confirm-{{ $exam->id }}-{{ $subject->id }}"
                               data-toggle="tooltip" title="Disable Exam" class="h-25 mr-4 px-3 bg-danger text-decoration-none text-light rounded-pill">
                                {{ __('Disable') }}
                            </a>
                            @include('dialog.exam.disable')
                        @else
                            <a href="{{ route('teacher.exam.enable', compact('teacher', 'exam', 'subject')) }}"
                               data-toggle="tooltip" title="Enable Exam" class="h-25 mr-4 px-3 bg-primary text-decoration-none text-light rounded-pill">
                                {{ __('Enable') }}
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        @include('dialog.exam.code')
        <form action="{{ route('teacher.exam.destroy', compact('teacher', 'exam')) }}" method="POST">
            @csrf
            @method('DELETE')
            @include('dialog.exam.delete')
        </form>
    </div>
</li>
