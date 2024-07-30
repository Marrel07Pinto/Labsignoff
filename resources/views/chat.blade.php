@extends($TA ? 'layouts.ta' : 'layouts.app')
@section('content')
<!DOCTYPE html>
<html>
    <body>
        <main id="main" class="main">
                <div class="pagetitle">
                    <h1><center>Chat</center></h1>
                </div><!-- End Page Title -->
                <section class="section">
                    @foreach($chatmessages as $item) 
                        <div class="chat-container">
                            <div class="chat-messages">
                                @if($item->users_id === Auth::id())
                                    <div class="message right-message" style="text-align: right">
                                        <span style="font-size: 60%">{{ $item->user->name }}</span>
                                        <h4>{{ $item->c_messages }}<span style="font-size: 40%; margin-left: 10px;">{{ $item->created_at->toTimeString() }}</span></h4>                                    
                                    </div>
                                @else
                                    <div class="message left-message" style="text-align: left">
                                        <span style="font-size: 60%">{{ $item->user->name }}</span>
                                        <h4>{{ $item->c_messages }}<span style="font-size: 40%; margin-left: 10px;">{{ $item->created_at->toTimeString() }}</span></h4>                                    
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                        <form id="chat_form" action="{{route('chat_form') }}" method="POST">
                            @csrf
                                <div class="chat-input">
                                    <input type="text" placeholder="Type a message..." id="c_messages" name="c_messages" required>
                                    <button>Send</button>
                                </div>
                        </form>
                </section>           
        </main>
    </body>
</html>
@endsection