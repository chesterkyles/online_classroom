<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Subject;
use App\Teacher;
use App\User;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($user_id, Subject $subject)
    {
        $user = User::where('account_number', $user_id)->first(); // auth()->user()
        $posts = $subject->posts()->get();
        return view('room.index', compact('user', 'subject', 'posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post(Request $request, $user_id, Subject $subject)
    {
        $subject->posts()->create($this->validateRequest());
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function comment(Request $request, $user_id, Subject $subject, Post $post)
    {
        $post->comments()->create($this->validateRequest());
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
    public function destroyPost($user_id, Subject $subject, Post $post)
    {
        $post->delete();
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
    public function destroyComment($user_id, Subject $subject, Post $post, Comment $comment)
    {
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
}
