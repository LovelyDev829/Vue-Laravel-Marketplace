<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatThread;
use Auth;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chat_threads = ChatThread::orderBy('created_at', 'desc');
        $chat_threads = $chat_threads->paginate(12);

        return view('backend.chats.index', compact('chat_threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chatThread = ChatThread::with('chats.sender')->findOrFail($id);
        return view('backend.chats.show', compact('chatThread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function refresh(Request $request)
    {
        $chatThread = ChatThread::with('chats.sender')->findOrFail($request->id);
        $chats = Chat::where('chat_thread_id', $chatThread->id)->where('id', '>', $request->lastMessageId)->get();

        return [
            'view' => view('backend.chats.refresh', compact('chats'))->render(),
            'lastMessageId' => $chats->count() > 0 ? $chats->last()->id : $request->lastMessageId
        ];
    }

    public function reply(Request $request)
    {
        $chatThread = ChatThread::with('chats.sender')->findOrFail($request->id);
        $chatThread->last_message_at = date("Y-m-d H:i:s");
        $chatThread->save();
        
        Chat::create([
            'chat_thread_id' => $chatThread->id,
            'user_id' => Auth::user()->id,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => translate('Your message has been sent successfully.')
        ]);
    }
}
