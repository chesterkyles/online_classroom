@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 d-block">
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

            <div class="col-lg-12 d-block d-md-flex m-0 p-0">
                <div class="col-12 col-md-8 d-block">
                    <div class="card mb-4">
                        <div class="card-header h5">
                            {{ $subject->name}}
                            <small>{{ '('. $subject->description .')' }}</small>
                        </div>
                        <div class="card-body p-0">
                            <div class="form-group d-block px-4 pt-4">
                                <form action="{{ route($user->account_type . '.subject.room.post', [$user->getAccountType(), 'subject' => $subject]) }}"  method="post">
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
                                    <li class="list-group-item m-0 bg-light" style="display:none;">
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
                                                    <a href="#" class="ml-2">Like</a>
                                                    <a href="#comment{{ $post->id }}" class="ml-2" data-toggle="collapse" role="button">Comment</a>
                                                    @if($post->user->id == $user->id)
                                                        <a href="#" class="ml-2" data-toggle="modal" data-target="#delete_post_confirm-{{ $post->id }}">Delete</a>
                                                    @endif
                                                    <form action="{{ route($user->account_type . '.subject.room.destroyPost',
                                                            [$user->getAccountType(), 'subject' => $subject, 'post' => $post]) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        @include('dialog.room.delete-post')
                                                    </form>
                                                </footer>
                                                <div class="collapse" id="comment{{ $post->id }}">
                                                    <hr>
                                                    <div class="text-right">
                                                        <form action="{{ route($user->account_type . '.subject.room.comment',
                                                            [$user->getAccountType(), 'subject' => $subject, 'post' => $post]) }}" method="post">
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
                                                                        <a href="#" class="ml-2">Like</a>
                                                                        @if($comment->user->id == $user->id)
                                                                            <a href="#" class="ml-2" data-toggle="modal" data-target="#delete_comment_confirm-{{ $comment->id }}">Delete</a>
                                                                        @endif
                                                                        <form action="{{ route($user->account_type . '.subject.room.destroyComment',
                                                                            [$user->getAccountType(), 'subject' => $subject, 'post' => $post, 'comment' => $comment]) }}" method="post">
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
                                                    <a href="#" id="commentMore{{ $post->id }}" class="viewMore">View More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="text-center mt-2 mb-4">
                                <a href="#" id="postMore" class="viewMore">View More</a>
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

@section('scripts')
    <script>
        $(document).ready(function () {
            $('form a').click(function() {
               $('input[name="'+$(this).attr('name') +'"]').click();
            });

            $('a.viewMore').click(function() {
                let items = $('ul#' + $(this).attr('id') + 'List > li:hidden');
                let pre_show = ($(this).attr('id').indexOf('post') >= 0) ? 10 : 2;
                if(items.length > 0) {
                    items.slice(0,pre_show).show();
                    if (items.length < (pre_show + 1)) $(this).html("");
                } else {
                    $(this).html("");
                }
                return false;
            });
            $('a.viewMore').click();
        });
    </script>
@endsection


