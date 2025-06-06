<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class MessagesController extends Controller
{
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $validate = Validator::make($request->all(), [
            'reciever_id' => 'required',
            'message_content' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'messages' => $validate->errors()
            ], 400);
        }

        try {
            $message = Message::create([
                'sender_id' => $user->id,
                'reciever_id' => $request->reciever_id,
                'message_content' => $request->message_content,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'messages' => 'created data messages has been successful!',
                'data' => $message
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'messages' => $th
            ], 400);
        }
    }

    public function show(int $id)
    {
        try {
            $dataMessage = Message::find($id);

            if (!$dataMessage) {
                return response()->json([
                    'success' => false,
                    'messages' => "data $id not found"
                ], 404);
            }

            return response()->json([
                'success' => true,
                'messages' => 'get data message has been successful!',
                'data' => $dataMessage
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'messages' => $th
            ], 400);
        }
    }

    public function getMessagesByID(int $user_id)
    {
        try {
            $messages = Message::where('sender_id', $user_id)->get();

            return response()->json([
                'success' => true,
                'messages' => "get data has been successful!",
                'count' => $messages->count(),
                'data' => $messages
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'messages' => $th
            ], 400);
        }
    }

    public function destroy(int $id)
    {
        $data = Message::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'messages' => "data $id not found"
            ], 404);
        }

        try {
            Message::destroy($id);

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
