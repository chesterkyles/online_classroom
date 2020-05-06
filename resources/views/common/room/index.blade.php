@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 d-block">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb px-4">
                        <li class="breadcrumb-item active">
                            <a href="{{ route($user->account_type . '.subject.index', $user->getAccountType()) }}">Classes</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route($user->account_type . '.subject.show', [$user->getAccountType(), 'subject' => $subject]) }}">
                                {{ $subject->name }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Room</li>
                    </ol>
                </nav>
            </div>

            <div class="col-12 d-block d-md-flex m-0 p-0" style="padding-top: 5000px">
                <div class="col-12 col-md-8 d-block">
                    <div class="card mb-4">
                        <div class="d-flex card-header h5 justify-content-between align-items-center">
                            <div class="bg-secondary text-light border rounded p-2">
                                {{ $subject->name }}<small>{{ ' ('. $subject->schedule .') ' }}</small>
                            </div>
                            <div class="mr-2">
                                <a href="#" data-toggle="modal" data-target="#bookmark-{{ $subject->id }}"
                                   data-toggle="tooltip" title="Bookmark"
                                   class="btn @if($subject->is_bookmarked) btn-danger @else btn-secondary @endif btn-sm rounded">
                                    @if($subject->is_bookmarked)
                                        <div class="mr-1 d-inline">{{ __('Remove') }}</div>
                                    @endif
                                    <i class="fa fa-bookmark"></i>
                                </a>
                            </div>
                        </div>
                        <form action="{{ route('classroom.bookmark', compact('subject')) }}" method="post">
                            @csrf
                            @include('dialog.room.bookmark')
                        </form>
                        <div class="card-body p-0">
                            <div class="form-group d-block px-4 pt-4">
                                <form action="{{ route('classroom.post', compact('subject')) }}"  method="post">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <textarea id="name" rows="3" class="form-control" style="resize:none"
                                              placeholder="Write something here" name="name" autofocus></textarea>
                                    <div class="d-flex justify-content-between">
                                        <div class="my-2">
                                            <a href="#" name="attachment" class="btn btn-light rounded-pill"><i class="fa fa-paperclip mr-1"></i>Attachment</a>
                                            <input type="file" name="attachment" style="display:none"
                                                   accept=".xlsx, .xls, .csv, .txt, .pdf, .doc, .docx, .ppt, .pptx, text/html, text/plain">
                                            <a href="#" name="photo" class="btn btn-light rounded-pill"><i class="fa fa-photo mr-1"></i>Photo</a>
                                            <input type="file" name="photo" style="display:none" accept="image/*">
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="mt-2 btn btn-primary">Post</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <ul class="list-group mt-2 mx-4" id="postMoreList">
                                @foreach($posts as $post)
                                    <li class="list-group-item m-0 px-1 bg-light" style="display:none;" id="notif-{{ $post->id }}">
                                        <div class="d-flex px-2">
                                            <div class="px-1" style="width:50px;">
                                                <img src="https://vectorified.com/images/default-image-icon-7.jpg" alt="" class="img-thumbnail rounded-circle">
                                            </div>
                                            <div class="col px-2">
                                                <div class="font-weight-bolder">{{ $post->user->full_name }}
                                                    @if($post->user->account_type == 'teacher')
                                                        <i class="ml-2 fa fa-check text-primary"></i>
                                                    @endif
                                                </div>
                                                <div class="card-text mb-2">{!! nl2br(e($post->name)) !!} </div>
                                                <footer class="text-muted small">
                                                    {{ $post->created_at }}
                                                    <a href="#" id="{{ $post->id }}" name="like-post" class="ml-2">
                                                        @if($post->is_liked) Unlike @else Like @endif
                                                    </a>
                                                    <span class="d-inline @if($post->likes->count()) mx-1 px-1 small rounded-circle bg-info text-light @endif">{{ $post->likes->count() ?: '' }}</span>
                                                    <text class="ml-1">&middot;</text>
                                                    <a href="#comment{{ $post->id }}" class="ml-1" data-toggle="collapse" role="button">Comment</a>
                                                    @if($post->comments->count())
                                                        <span class="d-inline mx-1 px-1 small rounded-circle bg-info text-light">{{ $post->comments->count() }}</span>
                                                    @endif
                                                    @if($post->user->id == $user->id)
                                                        <text class="ml-1">&middot;</text>
                                                        <a href="#" class="ml-1" data-toggle="modal" data-target="#delete_post_confirm-{{ $post->id }}">Delete</a>
                                                    @endif
                                                    <form action="{{ route('classroom.destroyPost', compact('subject', 'post')) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        @include('dialog.room.delete-post')
                                                    </form>
                                                </footer>
                                                <div class="collapse" id="comment{{ $post->id }}">
                                                    <hr>
                                                    <div class="text-right">
                                                        <form action="{{ route('classroom.comment', compact('subject', 'post')) }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                            <textarea rows="2" class="form-control" style="resize:none"
                                                                      placeholder="Write your comment here" name="name" autofocus></textarea>
                                                            <button type="submit" class="mt-2 btn btn-primary">Submit</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <ul class="m-0 p-0" id="commentMore{{ $post->id }}List">
                                                    @foreach($post->comments as $comment)
                                                        <hr>
                                                        <li class="list-group-item border-0 m-0 p-0 bg-light" style="display:none;">
                                                            <div class="d-flex px-2">
                                                                <div class="px-1" style="width:50px;">
                                                                    <img src="https://vectorified.com/images/default-image-icon-7.jpg" alt="" class="img-thumbnail rounded-circle">
                                                                </div>
                                                                <div class="col px-2">
                                                                    <div class="font-weight-bolder">{{ $comment->user->full_name }}
                                                                        @if($comment->user->account_type == 'teacher')
                                                                            <i class="ml-2 fa fa-check text-primary"></i>
                                                                        @endif
                                                                    </div>
                                                                    <div class="card-text mb-2">{!! nl2br(e($comment->name)) !!} </div>
                                                                    <footer class="text-muted small">{{ $comment->created_at }}
                                                                        <a href="#" id="{{ $comment->id }}" name="like-comment"  class="ml-2">
                                                                            @if($comment->is_liked) Unlike @else Like @endif
                                                                        </a>
                                                                        <span class="d-inline @if($comment->likes->count()) mx-1 px-1 small rounded-circle bg-info text-light @endif">{{ $comment->likes->count() ?: '' }}</span>
                                                                        @if($comment->user->id == $user->id)
                                                                            <a href="#" class="ml-2" data-toggle="modal" data-target="#delete_comment_confirm-{{ $comment->id }}">Delete</a>
                                                                        @endif
                                                                        <form action="{{ route('classroom.destroyComment', compact('subject', 'post', 'comment')) }}" method="post">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            @include('dialog.room.delete-comment')
                                                                        </form>
                                                                    </footer>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="text-center my-2">
                                                    <a href="#" id="commentMore{{ $post->id }}" class="viewMore">Load More Comments</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="text-center mt-2 mb-4">
                                <a href="#" id="postMore" class="viewMore">Load More Posts</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 d-block">
                    <div class="card mb-4">
                        <div class="card-header h5">
                            {{ __('Upcoming Events') }}
                        </div>
                        <div class="card-body p-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('common.room.jquery')

