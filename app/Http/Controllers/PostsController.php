<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user:id,name', 'comments' => function ($query) {
            $query->select('post_id', 'user_id', 'content', 'updated_at')->with(['user:id,name']);
        }, 'likes'])->get();

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:255',
            'img_url' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $post = Post::create([
            'user_id' => $user->id,
            'content' => $request->content,
            'img_url' => $request->img_url
        ]);

        return response()->json([
            'success' => true,
            'message' => 'create data post successful!',
            'data' => $post
        ], 201);
    }

    public function show($id)
    {
        $post = Post::find($id);
        return response()->json([
            'success' => true,
            'data' => $post
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:255',
            'img_url' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $post = Post::find($id);

        $post->content = $request->content;
        $post->img_url = $request->img_url;

        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'Update data has successful',
            'data' => $post
        ], 200);
    }

    public function destroy(int $id)
    {
        if (!Post::find($id)) {
            return response()->json([
                'success' => false,
                'message' => "post id $id not found"
            ], 404);
        }

        Post::destroy($id);

        return response()->json([
            'success' => true,
            'message' => "Post id $id has been deleted"
        ], 200);
    }
}
