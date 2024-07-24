@extends('layouts.admin')
@section('content')
<body>
        <main id="main" class="main">
                <div class="pagetitle">
                    <h1><center>Chat</center></h1>
                </div><!-- End Page Title -->
                <section class="section">
                    @foreach($chatmessages as $item)
                        <div class="chat-container">
                            <div class="chat-messages">
                                @if (Str::startsWith($item->user->u_num, 'TA-'))
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
                </section>           
        </main>
</body>
@endsection