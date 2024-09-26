<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($postId)
    {
        $comments = Comment::where('post_id', $postId)->orderBy('created_at', 'desc')->get();
        $comments->each->user;
        return $comments;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $postId)
    {
        $comment = new Comment;
        $comment->comment_body = $request->input("comment");
        $comment->user_id = $request->user()->id;
        $comment->post_id = $postId;
        $comment->save();
        $comments = Comment::where('post_id', $postId)->orderBy('created_at', 'desc')->get();
        $comments->each->user;
        return $comments;
        // return response(["comment" => $comment]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Comment::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $postId, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        if($comment->user == Auth::user() || Auth::user()->isAdmin)
        {
            $comment->comment_body = $request->comment_body;
            $comment->comment_likes = $request->comment_likes;
            $comment->save();
            return $comment;
        }
        else{
            return response(["message"=>"User not allowed to edit this comment."], 403); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($postId, $commentId)
    {
        $comment = Comment::find($commentId);
        if($comment && ($comment->user == Auth::user() || Auth::user()->isAdmin))
        {
            Comment::destroy($commentId);
            return response(["message" => "Comment deleted successfully"]);
        }
        else{
            return response(["message"=>"User not allowed to delete this comment."], 403);
        }
    }
}
