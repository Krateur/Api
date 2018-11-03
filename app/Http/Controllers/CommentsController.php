<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\StoreCommentRequest;
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

    public function store(StoreCommentRequest $request)
    {
        $mode_id = Input::get('comment_id');
        $model = Input::get('comment_type');

        if(Comment::isCommentAble($model, $mode_id))
        {
            $comment = Comment::create([
                'comment_id' => $mode_id,
                'comment_type' => $model,
                'username' => Input::get('username'),
                'email' => Input::get('email'),
                'reply' => Input::get('reply'),
                'content' => Input::get('content'),
                'ip' => $request->ip()

            ]);
            return Response::json($comment, 200, [], JSON_NUMERIC_CHECK);
        }
        else
        {
            return Response::json("Ce contenu n'est pas commentable", 422);
        }
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        if($comment->ip == \Illuminate\Support\Facades\Request::ip())
        {
            Comment::where('reply', '=', $comment->id)->delete();
            $comment->delete();
            return Response::json($comment, 200, [], JSON_NUMERIC_CHECK);
        }
        else
        {
            return Response::json("Ce contenu ne vous appartient pas", 403);
        }

    }
}
