<!-- resources/views/partials/chatrefresh.blade.php -->
@foreach($chatmessages as $item)
    <div class="message {{ $item->users_id === Auth::id() ? 'right-message' : 'left-message' }}">
        <div class="message-content">
            <h6>{{ $item->c_messages }}</h6>
        </div>
        <div class="message-meta {{ $item->users_id === Auth::id() ? 'right-message-meta' : 'left-message-meta' }}">
            <span>{{ $item->user->name }}</span>
            <span style="margin-left: 10px;">{{ $item->created_at->toTimeString() }}</span>
        </div>
    </div>
@endforeach
