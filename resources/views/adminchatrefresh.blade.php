@foreach($chatmessages as $item)
    <div class="message {{ Str::startsWith($item->user->role, 'TA') || Str::startsWith($item->user->role, 'ADMIN') ? 'right-message' : 'left-message' }}">
        <div class="message-content">
            <h6>{{ $item->c_messages }}</h6>
        </div>
        <div class="message-meta {{ Str::startsWith($item->user->role, 'TA') || Str::startsWith($item->user->role, 'ADMIN') ? 'right-message-meta' : 'left-message-meta' }}">
            <span>{{ $item->user->name }}</span>
            <span>{{ $item->created_at->toTimeString() }}</span>
        </div>
    </div>
@endforeach