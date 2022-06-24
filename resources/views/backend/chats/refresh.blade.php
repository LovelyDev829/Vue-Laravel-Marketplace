@foreach ($chats as $key => $chat)
    @if ($chat->user_id == $chat->chat_thread->user_id)
        @if ($chat->message != null)
            <div class="chat-coversation d-inline-flex">
                <div class="media">
                    <span class="avatar avatar-xs flex-shrink-0" data-toggle="tooltip" title="{{ $chat->sender->name }}">
                        <img src="{{ uploaded_asset($chat->sender->avatar)}}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                    </span>
                    <div class="media-body">
                        <div class="text bg-soft-secondary">{{$chat->message}}</div>
                        <div>
                            <span class="time">{{ Carbon\Carbon::parse($chat->created_at)->diffForHumans()}}</span>
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
                        <span class="time">{{ Carbon\Carbon::parse($chat->created_at)->diffForHumans()}}</span>
                    </div>
                    <span class="avatar avatar-xs flex-shrink-0" data-toggle="tooltip" title="{{$chat->sender->name}}">
                        <img src="{{ uploaded_asset($chat->sender->avatar)}}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                    </span>
                </div>
            </div>
        @endif
    @endif
@endforeach