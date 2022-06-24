<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConversationMessageResource;
use App\Http\Resources\ConversationResource;
use App\Mail\ConversationMailManager;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;
use Mail;

class ConversationController extends Controller
{
    public function index()
    {
        if (get_setting('conversation_system') == 1) {
            $conversations = Conversation::where('sender_id', Auth::user()->id)->orWhere('receiver_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
            return view('backend.conversations.index', compact('conversations'));
        }
        else {
            flash(translate('Conversation is disabled at this moment'))->warning();
            return back();
        }
    }
    
    public function show($id)
    {
        $conversation = Conversation::findOrFail(decrypt($id));
        if ($conversation->sender_id == Auth::user()->id) {
            $conversation->sender_viewed = 1;
        }
        elseif($conversation->receiver_id == Auth::user()->id) {
            $conversation->receiver_viewed = 1;
        }
        $conversation->save();
        return view('backend.conversations.show', compact('conversation'));
    }

    # add new message
    public function storeMessage(Request $request)
    {
        $message = new Message();
        $message->conversation_id = $request->conversation_id;
        $message->user_id = Auth::user()->id;
        $message->message = $request->message;
        $message->save();
        $conversation = $message->conversation;
        if ($conversation->sender_id == Auth::user()->id) {
            $conversation->sender_viewed ="1";
            $conversation->receiver_viewed ="0";
        }
        elseif($conversation->receiver_id == Auth::user()->id) {
            $conversation->sender_viewed ="0";
            $conversation->receiver_viewed ="1";
        }
        $conversation->save();
        flash(translate('Message has been sent'))->success();
        return back();
    }

}
