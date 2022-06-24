<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Http\Resources\ConversationMessageResource;
use App\Http\Resources\ConversationResource;
use App\Mail\ConversationMailManager;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use Auth; 
use Mail;


class ConversationController extends Controller
{
    # get all by customer
    public function index(){
        return response()->json([
            'success' => true,
            'message' => '',
            'data' => ConversationResource::collection(Conversation::where('sender_id', Auth::user()->id)->orWhere('receiver_id', Auth::user()->id)->latest()->get()),
        ]);
    }

    # show conversation messages
    public function show($id){
        $conversation = Conversation::findOrFail(decrypt($id));
        if ($conversation->sender_id == Auth::user()->id) {
            $conversation->sender_viewed = 1;
        }
        elseif($conversation->receiver_id == Auth::user()->id) {
            $conversation->receiver_viewed = 1;
        }
        $conversation->save();
        return [
            'success' => true,
            'data'    => new ConversationMessageResource($conversation)
        ];
    }

    # add new conversation by customer
    public function store(Request $request)
    {
        $user_type = Product::findOrFail($request->product_id)->shop->user->user_type;

        $conversation = new Conversation;
        $conversation->sender_id = Auth::user()->id;
        $conversation->receiver_id = Product::findOrFail($request->product_id)->shop->user->id;
        $conversation->title = $request->title;

        if($conversation->save()) {
            $message = new Message;
            $message->conversation_id = $conversation->id;
            $message->user_id = Auth::user()->id;
            $message->message = $request->message;

            if ($message->save()) {
                $this->send_message_notification($conversation, $message, $user_type);
            }
        }

        return response()->json([
            'success' => true, 
            'message' => translate('Message has been sent to seller')
        ]); 
    }

    # add new message
    public function storeMessage(Request $request)
    {
        $message = new Message;
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

        return response()->json([
            'success' => true,
            'message' => translate('Message has been sent'),
            'data' => new ConversationMessageResource($conversation),
        ]);
    }

    # send email
    public function send_message_notification($conversation, $message, $user_type)
    {
        $array['view'] = 'emails.conversation';
        $array['subject'] = 'Sender:- '.Auth::user()->name;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['content'] = 'Hi! You recieved a message from '.Auth::user()->name.'.';
        $array['sender'] = Auth::user()->name;
        $array['link'] =  env('APP_NAME');

        if($user_type == 'admin') {
            $array['link'] = route('querries.show', encrypt($conversation->id));
        } else {
            $array['link'] = route('seller.querries.show', encrypt($conversation->id));
        }

        $array['details'] = $message->message;

        try {
            Mail::to($conversation->receiver->email)->queue(new ConversationMailManager($array));
        } catch (\Exception $e) {
            //dd($e->getMessage());
        }
    }
}
