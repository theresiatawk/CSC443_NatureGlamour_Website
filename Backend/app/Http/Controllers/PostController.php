<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User; 
use Validator;

class PostController extends Controller
{
    function addPost(Request $request) {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'caption' => 'required|string'
        ]);
        if($validate->fails()){
            return response()->json([
                "status" => "error",
                "results" => "Some fields are empty"
            ], 400);
        }
        if ($request->hasFile('image')) {
             // Only allow .jpg, .jpeg and .png file types.
            $validate_img = Validator::make($request->all(), [
                'image' => 'mimes:jpeg,jpg,png'
            ]);
            if($validate->fails()){
                return response()->json([
                    "status" => "error",
                    "results" => "Invalid file type."
                ], 400);
            }
            $user = User::find($request->user_id);
            if(!$user){
                return response()->json([
                    "status" => "error",
                    "results" => "Invalid User"
                ], 401);
            } 
            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->image->store('posts', 'public');

            // Store the record, using the new file hashname which will be it's new filename identity.
            $post = new Post;
            $post->user_id = $request->user_id;
            $post->url = $request->image->hashName();
            $post->caption = $request->caption;
            if($post->save()){
                return response()->json([
                    'status' => 'success',
                    'results' => 'Image Added',
                    'post' => $post
                ], 200);
            };
        }
        else{
            return response()->json([
                "status" => "error",
                "results" => "Missing an image"
            ], 400);
        }
    }

    function deletePost(Request $request){
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'post_id' => 'required|string',
        ]);
        if($validate->fails()){
            return response()->json([
                "status" => "error",
                "results" => "Some fields are empty"
            ], 400);
        }
        // Check if image exist
        $post = Post::find($request->post_id);
        if(!$post){
            return response()->json([
                "status" => "error",
                "results" => "Image does not exist"
            ], 400);
        }
        // Check if user is allowed to delete it
        $postt = Post::where("user_id", $request->user_id)
                    ->where("id", $request->id)
                    ->get();
        
        if(!$postt){
            return response()->json([
            "status" => "error",
            "results" => "This user is not allowed to delete this image"
            ], 400);
        }
        $img_path = public_path().'/'.$postt->url;

    }
}
