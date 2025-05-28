<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'post_id' => 'required',
            'user_id' => 'required',
            'content' => 'required|string|max:255'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'messages' => $validate->errors()
            ], 400);
        }

        try {
            $comment = Comment::create([
                'post_id' => $request->post_id,
                'user_id' => $request->user_id,
                'content' => $request->content,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'messages' => 'created data comment from user ' . $request->user_id . ' to post ' . $request->post_ic . ' has been successful!',
                'data' => $comment
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'succes' => false,
                'message' => $th,
            ], 400);
        }
    }

    public function destroy(int $id)
    {
        $user = Comment::find($id);

        if (!$user) {
            return response()->json([
                'success' => 'false',
                'messages' => 'Data has not been found'
            ], 404);
        }

        try {
            Comment::destroy($id);
            return response()->json([
                'success' => true,
                'messages' => "Data $id has been destroy",
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'messages' => $th
            ]);
        }
    }
}
