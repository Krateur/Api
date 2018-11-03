<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class CommentsController extends Controller
{
    public function index()
    {
        $comment = Comment::allFor(Input::get('id'), Input::get('type'));
        return Response::json($comment, 200, [], JSON_NUMERIC_CHECK);
    }

    public function store()
    {
        $comment = Comment::create([
           'comment_id' => Input::get('comment_id'),
           'comment_type' => Input::get('comment_type'),
           'username' => Input::get('username'),
           'email' => Input::get('email'),
           'content' => Input::get('content'),
           'ip' => \Illuminate\Support\Facades\Request::ip()

        ]);
        return Response::json($comment, 200, [], JSON_NUMERIC_CHECK);
    }
}
