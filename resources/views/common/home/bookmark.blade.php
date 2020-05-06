<div class="card mb-4">
    <div class="card-header py-3">
        <strong class="ml-1 h4"><i class="fa fa-bookmark text-primary mr-2"></i>{{ __('Bookmarks') }}</strong>
    </div>
    <div class="card-body">
        <ul class="list-group">
            @foreach(auth()->user()->subjects as $subject)
                <li class="list-group-item justify-content-between d-flex">
                    <a href="{{ route('classroom.index', compact('subject')) }}">
                        {{ $subject->pivot->name }}
                    </a>
                    <a href="#" data-toggle="modal" data-target="#remove_bookmark-{{ $subject->id }}"
                       data-toggle="tooltip" title="Remove"><i class="fa fa-close small text-danger"></i></a>
                </li>
                <form action="{{ route('classroom.bookmark', compact('subject')) }}" method="post">
                    @csrf
                    @include('dialog.room.remove-bookmark')
                </form>
            @endforeach
        </ul>
    </div>
</div>

