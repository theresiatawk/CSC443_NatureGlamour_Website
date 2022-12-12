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
            'post_id' => 'required|integer'
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
        if($comment->save()){
            return response()->json([
                'status' => 'success',
                'results' => 'Comment Added',
                'comment' => $comment
            ], 200);
        }
    }
}
