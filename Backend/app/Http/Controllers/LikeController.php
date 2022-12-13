<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use Validator;



class LikeController extends Controller
{
    function addLike(Request $request){
        $validate = Validator::make($request->all(), [
            'post_id' => 'required|integer'
        ]);
        if($validate->fails()){
            return response()->json([
                "status" => "error",
                "results" => "Some fields are empty"
            ], 400);
        }
        $user = Auth::user();
        $user_id = $user->id;
        //Check if user and post exists
        $user = User::find($user_id);
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
                    ->where("user_id",$user_id)
                    ->get();
        if(count($like) > 0){
            return response()->json([
                "status" => "error",
                "results" => "User already like this post"
            ], 401);
        }
        // Adding new like
        $like = new Like;
        $like->user_id = $user_id;
        $like->post_id = $request->post_id;
        if($like->save()){
            return response()->json([
                'status' => 'success',
                'results' => 'Like Added',
            ], 200);
        }
    }
    function deleteLike(Request $request){
        $validate = Validator::make($request->all(), [
            'post_id' => 'required|integer'
        ]);
        if($validate->fails()){
            return response()->json([
                "status" => "error",
                "results" => "Some fields are empty"
            ], 400);
        }
        $user = Auth::user();
        $user_id = $user->id;
        //Check if like exist
        $like = Like::where("post_id",$request->post_id)
                    ->where("user_id",$user_id)
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
    function getLikes($post_id){
        //Check if post exist
        $post = Post::find($post_id);
        if(!$post){
            return response()->json([
                "status" => "error",
                "results" => "Post does not exist"
            ], 404);
        }
        // Get username of likes
        $likes = DB::table('users')
            ->join('likes', 'users.id', '=', 'likes.user_id')
            ->where('likes.post_id', '=', $post_id)
            ->select('users.username')
            ->get();

        if(count($likes) == 0){
            return response()->json([
                'status' => 'failure',
                'results' => 'No likes',
                'total' => 0
            ]);
        }
        return response()->json([
            'status' => 'success',
            'results' => 'Likes',
            'like' => $likes,
            'total' => count($likes)
        ], 200);   
    }
    function checkLike($post_id){
        //check if like exist
        $like = Like::where('user_id', $user_id)
                    ->where('post_id',$post_id)
                    ->get();
        if(count($like) == 0){
            return response()->json([
                'status' => 'success',
                'results' => 'false'
            ], 200);
        }
        return response()->json([
            'status' => 'success',
            'results' => 'true'
        ], 200);
    }
}
