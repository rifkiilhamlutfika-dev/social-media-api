<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class LikesController extends Controller
{
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
            'post_id' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'messages' => $validate->errors()
            ], 400);
        }

        try {
            $like = Like::create([
                'user_id' => $request->user_id,
                'post_id' => $request->post_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'messages' => 'created data like has been successful!',
                'data' => $like
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'messages' => $th
            ], 400);
        }
    }

    public function destroy(int $id)
    {
        $data = Like::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'messages' => "data $id not found"
            ], 404);
        }

        try {
            Like::destroy($id);

            return response()->json([
                'success' => true,
                'messages' => "data id $id has been deleted"
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'messages' => $th
            ], 400);
        }
    }
}
