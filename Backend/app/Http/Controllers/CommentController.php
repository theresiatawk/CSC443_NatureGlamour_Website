<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Validator;

class CommentController extends Controller
{
    function addComment(Request $request){
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'post_id' => 'required|integer',
            'comment' => 'required|string'
        ]);
        if($validate->fails()){
            return response()->json([
                "status" => "error",
                "results" => "Some fields are empty"
            ], 400);
        }
        //Check if user and post exists
        $user = User::find($request->user_id);
        $post = Post::find($request->post_id);
        if(!$user){
            return response()->json([
                "status" => "error",
                "results" => "Invalid User"
            ], 401);
        }
        if(!$post){
            return response()->json([
                "status" => "error",
                "results" => "Invalid Post"
            ], 401);
        }
        // Adding new Comment
        $comment = new Comment;
        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
        $comment->comment = $request->comment;
        if($comment->save()){
            return response()->json([
                'status' => 'success',
                'results' => 'Comment Added',
                'comment' => $comment
            ], 200);
        }
    }

    function deleteComment($comment_id){
        //Check if comment exist
        $comment = Comment::find($comment_id);
        if(!$comment){
            return response()->json([
                "status" => "error",
                "results" => "Comment does not exist"
            ], 404);
        }
        //Delete Comment
        if($comment->delete()){
            return response()->json([
                'status' => 'success',
                'results' => 'Comment Deleted',
                'like' => $comment
            ], 200);
        }
    }
    function getComments($post_id){
        //Check if post exist
        $post = Post::find($post_id);
        if(!$post){
            return response()->json([
                "status" => "error",
                "results" => "Post does not exist"
            ], 404);
        }
        //Getting username with content of each like
        $comments = DB::table('users')
            ->join('comments', 'users.id', '=', 'comments.user_id')
            ->where('comments.post_id', '=', $post_id)
            ->select('users.username', 'comments.comment')
            ->get();

        if(count($comments) == 0){
            return response()->json([
                'status' => 'failure',
                'results' => 'No Comments',
                'total' => 0
            ]);
        }
        return response()->json([
            'status' => 'success',
            'results' => 'Likes',
            'like' => $comments,
            'total' => count($comments)
        ], 200);   
    }

}
