@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html>
    <body>
        <main id="main" class="main">

            <div class="pagetitle">
                <h1><center>Chat</center></h1>
            </div><!-- End Page Title -->
            <section class="section">
                <div class="chat-container">
                    <div class="chat-messages">
                        <div class="message">
                            <p>Hey, how are you?</p>
                            <span>10:05 AM</span>
                        </div>
                        <div class="message self">
                            <p>I'm good, thanks!</p>
                            <span>10:06 AM</span>
                        </div>
                    </div>
                    <div class="chat-input">
                        <input type="text" placeholder="Type a message...">
                        <button>Send</button>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
@endsection