@extends('layouts.admin')
@section('content')
<style>
    .card-body {
    max-height: 80vh; 
    overflow-y: auto; 
    display: flex;
    flex-direction: column; 
}

.chat-messages {
    flex: 1; 
    display: flex;
    flex-direction: column;
    gap: 10px; 
}

.message {
    display: flex;
    flex-direction: column;
    padding: 10px;
    max-width: 80%;
    border-radius: 5px;
    position: relative;
}

.right-message {
    align-self: flex-end;
}

.left-message {
    align-self: flex-start;
}

.message-content {
    background-color: #e0f7fa; 
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 5px; 
}

.message-meta {
    font-size: 60%;
    color: #888;
}

.message-meta.right-message-meta {
    text-align: right; 
}

.message-meta.left-message-meta {
    text-align: left; 
}
   

    

    .chat-input {
        display: flex;
        gap: 10px;
        margin-top: 10px;
        width: 90%;
    }

    .chat-input input[type="text"] {
        flex: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .chat-input button {
        padding: 10px;
        border: none;
        background-color: #007bff;
        color: white;
        border-radius: 5px;
        cursor: pointer;
    }

    .chat-input button:hover {
        background-color: #0056b3;
    }
</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h1><center>Chat</center></h1>
    </div><!-- End Page Title -->
    <div class="card">
        <div class="card-body">
            <div class="chat-messages">
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
            </div>
            <center>
                <form id="chat_form" action="{{ route('chat_form') }}" method="POST">
                    @csrf
                    <div class="chat-input">
                        <input type="text" placeholder="Type a message..." id="c_messages" name="c_messages" required>
                        <button type="submit">Send</button>
                    </div>
                </form>
            </center>
        </div>
    </div>
</main>
@endsection
