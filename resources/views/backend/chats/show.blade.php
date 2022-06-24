@extends('backend.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">{{ translate('Messages of ') }} {{ optional($chatThread->customer)->name }}</h6>
    </div>
    <div class="card-body">
        <div class="border-0 shadow-none aiz-chat pb-7">
            <div class="chat-list-wrap c-scrollbar-light scroll-to-btm" style="height: calc(100vh - 350px);max-height: calc(100vh - 350px);">
                <div class="chat-list">
                    @foreach ($chatThread->chats as $key => $chat)
                        @if ($chat->user_id == $chatThread->user_id)
                            @if ($chat->message != null)
                                <div class="chat-coversation d-inline-flex">
                                    <div class="media">
                                        <span class="avatar avatar-xs flex-shrink-0" data-toggle="tooltip" title="{{ $chat->sender->name }}">
                                            <img src="{{ uploaded_asset($chat->sender->avatar)}}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                        </span>
                                        <div class="media-body">
                                            <div class="text bg-soft-secondary">{{$chat->message}}</div>
                                            <div>
                                                <span class="time">{{ $chat->created_at->diffForHumans()}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            @if ($chat->message != null)
                                <div class="chat-coversation right">
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="text">{{$chat->message}}</div>
                                            <span class="time">{{ $chat->created_at->diffForHumans()}}</span>
                                        </div>
                                        <span class="avatar avatar-xs flex-shrink-0" data-toggle="tooltip" title="{{$chat->sender->name}}">
                                            <img src="{{ uploaded_asset($chat->sender->avatar)}}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="chat-footer border-top p-3 attached-bottom bg-white">
                <form id="send-mesaage" onsubmit="send_reply(event)">
                    <div class="input-group">
                        <input type="hidden" id="chat_thread_id" name="chat_thread_id" value="{{ $chatThread->id }}">
                        <input type="text" class="form-control" name="message" id="message" name="message" placeholder="{{ translate('Your Message..') }}" autocomplete="off">
                        <input type="hidden" class="" name="attachment" id="attachment">
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-circle btn-icon" type="submit">
                                <i class="las la-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
    <script>

        var lastMessageId = '{{ $chatThread->chats()->latest()->first()->id }}';

        $(document).ready(function(){
            setInterval(() => {
                refreshChat()
            }, 5000);
        });

        function refreshChat(){
            $.post('{{ route('chats.refresh') }}', {_token: '{{ csrf_token() }}', id: $('input[name=chat_thread_id]').val(), lastMessageId: lastMessageId}, function(data){
                $('.chat-list').append(data.view);
                lastMessageId = data.lastMessageId;
                AIZ.extra.scrollToBottom();
            });
        }

        function send_reply(e){
            e.preventDefault();
            $.post('{{ route('chats.reply') }}', {_token: '{{ csrf_token() }}', id: $('input[name=chat_thread_id]').val(), message: $('input[name=message]').val()}, function(data){
                $('input[name=message]').val(null);
                refreshChat();
            });
        }

    </script>
@endsection
