<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use Validator;



class LikeController extends Controller
{
    function addLike(Request $request){
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
        //Check if user already like this post
        $like = Like::where("post_id",$request->post_id)
                    ->where("user_id",$request->user_id)
                    ->get();
        if(count($like) > 0){
            return response()->json([
                "status" => "error",
                "results" => "User already like this post"
            ], 401);
        }
        // Adding new like
        $like = new Like;
        $like->user_id = $request->user_id;
        $like->post_id = $request->post_id;
        if($like->save()){
            return response()->json([
                'status' => 'success',
                'results' => 'Like Added',
                'post' => $post
            ], 200);
        }
    }
    function deleteLike(Request $request){
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
        //Check if like exist
        $like = Like::where("post_id",$request->post_id)
                    ->where("user_id",$request->user_id)
                    ->get();
        if(count($like) == 0){
            return response()->json([
                "status" => "error",
                "results" => "Like does not exist"
            ], 404);
        }
        //Delete like
        if($like[0]->delete()){
            return response()->json([
                'status' => 'success',
                'results' => 'Like Deleted',
                'like' => $like
            ], 200);
        }
    }
}
