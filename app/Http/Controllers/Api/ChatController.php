<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ChatCollection;
use App\Models\Chat;
use App\Models\ChatThread;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $chat_thread = ChatThread::where('user_id', auth('api')->user()->id)->first();
        if($chat_thread){
            $chat_thread->chats()->update(['seen_by_customer' => 1]);
            return response()->json([
                'success' => true,
                'data' => new ChatCollection($chat_thread->chats)
            ]);
        }else{
            return response()->json([
                'success' => false,
                'data' => []
            ]);
        }
    }

    public function send(Request $request)
    {
        if(!$request->message){
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => translate('Please type your message.')
            ]);
        }

        $chat_thread = ChatThread::updateOrCreate(
            ['user_id' => auth('api')->user()->id],
            ['last_message_at' => date("Y-m-d H:i:s")]
        );

        $chat = Chat::create([
            'chat_thread_id' => $chat_thread->id,
            'user_id' => auth('api')->user()->id,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'user_id' => $chat->user_id,
                'message' => $chat->message,
                'time' => $chat->created_at->diffForHumans()
            ],
            'message' => translate('Your message has been sent successfully.')
        ]);
    }
    public function new_messages()
    {
        $chat_thread = ChatThread::where('user_id', auth('api')->user()->id)->first();

        if($chat_thread){
            $unseeen_chats = $chat_thread->chats()->where('user_id', '!=', auth('api')->user()->id)->where('seen_by_customer',0)->get();
            $chat_thread->chats()->update(['seen_by_customer' => 1]);
            return response()->json([
                'success' => true,
                'data' => new ChatCollection($unseeen_chats)
            ]);
        }else{
            return response()->json([
                'success' => false,
                'data' => []
            ]);
        }
    }
}