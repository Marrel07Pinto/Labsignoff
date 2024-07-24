@extends('layouts.seatgui')
@section('content')
<!DOCTYPE html>
<html>
<style>
    .left-side,.right-side {
    display: flex;
    flex-direction: column;
     
}
  
  .container button {
    width: 18%; /* Make buttons take full width of their parent */
    padding: 10px;
    margin: 5px 0;
    box-sizing: border-box; /* Ensures padding and border are included in the total width and height */
    cursor: pointer;
}
.container button:hover {
    background-color: #e2e6ea; /* Slightly darker background on hover */
}
form {
    margin-bottom: 20px; /* Add spacing between forms */
}
.container {
    display: flex;
    justify-content: space-between;
    padding: 20px; /* Optional: add padding for spacing */
}
</style>

    <body>
        <main id="main" class="main">

            <div class="pagetitle">
                <h1>Please select your seat</h1>
            </div><!-- End Page Title -->

            <section class="section">
            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            @if(session('success'))
                    <script>
                        // Redirect to home after 2 seconds if there is a session message
                        setTimeout(function() {
                            window.location.href = "{{ route('home') }}";
                        }, 2000);  // 2000 milliseconds = 2 seconds
                    </script>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('info'))
                        <div class="alert alert-info" id="infoAlert">
                            {{ session('info') }}
                            @php
                                $user_id = auth()->user()->id;
                            @endphp
                            <form id="seatForm" action="{{ url('/seat_vupdate/' . $user_id) }}" method="POST">
                                @csrf
                                <button type="submit" name="seat_number" value="{{ session('seat_number') }}">Yes</button>
                                <button type="button" onclick="hideConfirmation()">No</button>
                            </form>
                        </div>
                    @endif
            <div class="container">
                <div class="left-layout">
                        <form id="seatForm" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S1">S1</button>
                            <button type="submit" name="seat_number" value="S2">S2</button>
                            <button type="submit" name="seat_number" value="S3">S3</button>
                            <button type="submit" name="seat_number" value="S4">S4</button>
                            <button type="submit" name="seat_number" value="S5">S5</button>
                        </form>
                            <br>
                        <form id="seatForm2" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S10">S10</button>
                            <button type="submit" name="seat_number" value="S9">S9</button>
                            <button type="submit" name="seat_number" value="S8">S8</button>
                            <button type="submit" name="seat_number" value="S7">S7</button>
                            <button type="submit" name="seat_number" value="S6">S6</button>
                        </form>
                            <br>
                        <form id="seatForm3" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S11">S11</button>
                            <button type="submit" name="seat_number" value="S12">S12</button>
                            <button type="submit" name="seat_number" value="S13">S13</button>
                            <button type="submit" name="seat_number" value="S14">S14</button>
                            <button type="submit" name="seat_number" value="S15">S15</button>
                        </form>
                        <br>
                        <form id="seatForm4" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S20">S20</button>
                            <button type="submit" name="seat_number" value="S19">S19</button>
                            <button type="submit" name="seat_number" value="S18">S18</button>
                            <button type="submit" name="seat_number" value="S17">S17</button>
                            <button type="submit" name="seat_number" value="S16">S16</button>
                        </form>
                            </br>
                        <form id="seatForm5" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S21">S21</button>
                            <button type="submit" name="seat_number" value="S22">S22</button>
                            <button type="submit" name="seat_number" value="S23">S23</button>
                            <button type="submit" name="seat_number" value="S24">S24</button>
                            <button type="submit" name="seat_number" value="S25">S25</button>
                        </form>
                        </br>
                    </div>
                    <div class="right-layout">
                        <form id="seatForm6" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S26">S26</button>
                            <button type="submit" name="seat_number" value="S27">S27</button>
                            <button type="submit" name="seat_number" value="S28">S28</button>
                            <button type="submit" name="seat_number" value="S29">S29</button>
                            <button type="submit" name="seat_number" value="S30">S30</button>
                        </form>
                            <br>
                        <form id="seatForm6" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S35">S35</button>
                            <button type="submit" name="seat_number" value="S34">S34</button>
                            <button type="submit" name="seat_number" value="S33">S33</button>
                            <button type="submit" name="seat_number" value="S32">S32</button>
                            <button type="submit" name="seat_number" value="S31">S31</button>
                        </form>
                            <br>
                        <form id="seatForm8" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S36">S36</button>
                            <button type="submit" name="seat_number" value="S37">S37</button>
                            <button type="submit" name="seat_number" value="S38">S38</button>
                            <button type="submit" name="seat_number" value="S39">S39</button>
                            <button type="submit" name="seat_number" value="S40">S40</button>
                        </form>
                        <br>
                        <form id="seatForm9" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S45">S45</button>
                            <button type="submit" name="seat_number" value="S44">S44</button>
                            <button type="submit" name="seat_number" value="S43">S43</button>
                            <button type="submit" name="seat_number" value="S42">S42</button>
                            <button type="submit" name="seat_number" value="S41">S41</button>
                        </form>
                            </br>
                        <form id="seatForm10" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S46">S46</button>
                            <button type="submit" name="seat_number" value="S47">S47</button>
                            <button type="submit" name="seat_number" value="S48">S48</button>
                            <button type="submit" name="seat_number" value="S49">S49</button>
                            <button type="submit" name="seat_number" value="S50">S50</button>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
<script>
    function hideConfirmation() {
        document.getElementById('infoAlert').style.display = 'none';
    }
</script>
@endsection
