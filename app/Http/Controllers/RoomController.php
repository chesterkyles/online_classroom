<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Notifications\ClassPosted;
use App\User;
use App\Post;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Subject $subject)
    {
        $user = auth()->user();
        $posts = $subject->posts()->get();
        $posts->load('user', 'likes', 'comments', 'comments.user', 'comments.likes' );
        return view('common.room.index', compact('user', 'subject', 'posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post(Request $request, Subject $subject)
    {
        $details = [
            'user' => auth()->user()->full_name,
            'body' => Str::limit($request->name, 40),
            'class' => $subject->name_schedule,
            'slugURL' => $request->server('HTTP_REFERER'),
        ];

        $when = now()->addSeconds(30);
        Notification::send($subject->get_users(), (new ClassPosted($details))->delay($when));

        $subject->posts()->create($this->validateRequest());
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function comment(Request $request, Subject $subject, Post $post)
    {
        $post->comments()->create($this->validateRequest());
        return redirect()->back();
    }

    public function likePost(Request $request, Subject $subject)
    {
        $post = Post::where('id', $request->id)->first();
        $post->load(['likes' => $this->softDeleteLikes()]);
        if($post->is_liked)
            if(is_null($post->is_liked->deleted_at))
                $post->is_liked->delete();
            else
                $post->is_liked->restore();
        else
            $post->likes()->create(['user_id' => auth()->user()->id]);
        return response()->json([]);

    }

    public function likeComment(Request $request, Subject $subject, Post $post)
    {
        $comment = Comment::where('id', $request->id)->first();
        $comment->load(['likes' => $this->softDeleteLikes()]);
        if($comment->is_liked)
            if(is_null($comment->is_liked->deleted_at))
                $comment->is_liked->delete();
            else
                $comment->is_liked->restore();
        else
            $comment->likes()->create(['user_id' => auth()->user()->id]);
        return response()->json([]);
    }

    public function bookmark(Request $request, Subject $subject)
    {
        $user = auth()->user();
        if($subject->is_bookmarked)
            $subject->users()->detach($user);
        else
            $subject->users()->attach($user, ['name' => $request->name]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $user_id
     * @param Subject $subject
     * @param Post $post
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroyPost(Subject $subject, Post $post)
    {
        if($post->comments->count())
            foreach($post->comments as $comment) {
                $comment->likes()->forceDelete();
            }
        $post->likes()->forceDelete();
        $post->comments()->delete();
        $post->delete();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $user_id
     * @param Subject $subject
     * @param Post $post
     * @param Comment $comment
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroyComment(Subject $subject, Post $post, Comment $comment)
    {
        $comment->likes()->forceDelete();
        $comment->delete();
        return redirect()->back();
    }

    public function validateRequest()
    {
        return request()->validate([
            'user_id' => ['required'],
            'name' => ['required', 'string'],
        ]);
    }

    protected function softDeleteLikes()
    {
        return function ($query) {
            $query->withTrashed();
        };
    }
}
