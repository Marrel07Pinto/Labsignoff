@extends($TA ? 'layouts.ta' : 'layouts.app')
@section('content')
<style>
.card {
    height: 80%; 
    display: flex;
    flex-direction: column;
}
.card-body {
    max-height: 80vh; 
    overflow-y: auto; 
    display: flex;
    flex-direction: column;
    position: relative;
}

.chat-messages {
    flex: 1; 
    display: flex;
    flex-direction: column;
    gap: 10px;
    overflow-y: auto; /* Ensure overflow is handled */
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

.chat-msg {
    display: flex;
    gap: 10px;
    margin-top: 10px;
    width: 90%;
}

.chat-msg input[type="text"] {
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.chat-msg button {
    padding: 10px;
    border: none;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}

.chat-msg button:hover {
    background-color: #0056b3;
}
</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h1><center>Chat</center></h1>
    </div><!-- End Page Title -->
    <div class="card">
        <div class="card-body">
            <div class="chat-messages" id="chat-messages">
                @include('partials.chatrefresh', ['chatmessages' => $chatmessages])
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function fetchChatMessages() {
            $.ajax({
                url: '{{ route("chat.refresh") }}',
                method: 'GET',
                success: function(data) {
                    var chatMessages = document.getElementById('chat-messages');
                    var isScrolledToBottom = chatMessages.scrollHeight - chatMessages.clientHeight <= chatMessages.scrollTop + 1;

                    $('#chat-messages').html(data);

                    if (isScrolledToBottom) {
                        scrollToBottom();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                }
            });
        }

        function scrollToBottom() {
            var chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        $(document).ready(function() {
            fetchChatMessages();
            setInterval(fetchChatMessages, 1000);
            scrollToBottom();

            $('#chat_form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function() {
                        fetchChatMessages();
                        $('#c_messages').val('');
                        // Automatically scroll to the bottom after sending a message
                        scrollToBottom();
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error:", status, error);
                    }
                });
            });

            $('#c_messages').on('keypress', function(e) {
                if (e.which === 13) { 
                    e.preventDefault(); 
                    $('#chat_form').submit(); 
                }
            });
        });
    </script>
            
    </div>
    <center>
        <form id="chat_form" action="{{ route('chat_form') }}" method="POST">
            @csrf
            <div class="chat-msg">
                <input type="text" placeholder="Type a message..." id="c_messages" name="c_messages" maxlength="300" required>
                <button type="submit">Send</button>
            </div>
        </form>
    </center>
    </br>
</main>
@endsection
