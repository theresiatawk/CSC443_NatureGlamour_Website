<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Validator;

class PostController extends Controller
{
    function addPost(Request $resquest) {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);
        if($validate->fails()){
            return response()->json([
                "status" => "error",
                "results" => "Some fields are empty"
            ], 400);
        }
        if ($request->hasFile('file')) {
             // Only allow .jpg, .jpeg and .png file types.
            $request->validate([
                'image' => 'mimes:jpeg,jpg,png'
            ]);

            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->file->store('product', 'public');

            // Store the record, using the new file hashname which will be it's new filename identity.
            $post = new Post([
                "user_id" => $request->get('user_id'),
                "file_path" => $request->file->hashName()
            ]);
            $product->save();
        }
    }
}
