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
.red-seat {
        background-color: #f1807e;
        color: white;
    }
.green-seat {
        background-color: #94ffbd;
        color: black;
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
                @php
                    $seatNumbers = $seatsoccupied->pluck('seat_num')->toArray();
                @endphp
                <div class="left-layout">
                        <form id="seatForm" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S1" class="{{ in_array('S1', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S1</button>
                            <button type="submit" name="seat_number" value="S2" class="{{ in_array('S2', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S2</button>
                            <button type="submit" name="seat_number" value="S3" class="{{ in_array('S3', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S3</button>
                            <button type="submit" name="seat_number" value="S4" class="{{ in_array('S4', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S4</button>
                            <button type="submit" name="seat_number" value="S5" class="{{ in_array('S5', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S5</button>
                        </form>
                        <br>
                        <form id="seatForm2" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S10" class="{{ in_array('S10', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S10</button>
                            <button type="submit" name="seat_number" value="S9" class="{{ in_array('S9', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S9</button>
                            <button type="submit" name="seat_number" value="S8" class="{{ in_array('S8', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S8</button>
                            <button type="submit" name="seat_number" value="S7" class="{{ in_array('S7', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S7</button>
                            <button type="submit" name="seat_number" value="S6" class="{{ in_array('S6', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S6</button>
                        </form>
                        <br>
                        <form id="seatForm3" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S11" class="{{ in_array('S11', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S11</button>
                            <button type="submit" name="seat_number" value="S12" class="{{ in_array('S12', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S12</button>
                            <button type="submit" name="seat_number" value="S13" class="{{ in_array('S13', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S13</button>
                            <button type="submit" name="seat_number" value="S14" class="{{ in_array('S14', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S14</button>
                            <button type="submit" name="seat_number" value="S15" class="{{ in_array('S15', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S15</button>
                        </form>
                        <br>
                        <form id="seatForm4" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S20" class="{{ in_array('S20', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S20</button>
                            <button type="submit" name="seat_number" value="S19" class="{{ in_array('S19', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S19</button>
                            <button type="submit" name="seat_number" value="S18" class="{{ in_array('S18', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S18</button>
                            <button type="submit" name="seat_number" value="S17" class="{{ in_array('S17', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S17</button>
                            <button type="submit" name="seat_number" value="S16" class="{{ in_array('S16', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S16</button>
                        </form>
                        </br>
                        <form id="seatForm5" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S21" class="{{ in_array('S21', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S21</button>
                            <button type="submit" name="seat_number" value="S22" class="{{ in_array('S22', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S22</button>
                            <button type="submit" name="seat_number" value="S23" class="{{ in_array('S23', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S23</button>
                            <button type="submit" name="seat_number" value="S24" class="{{ in_array('S24', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S24</button>
                            <button type="submit" name="seat_number" value="S25" class="{{ in_array('S25', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S25</button>
                        </form>
                        </br>
                    </div>
                    <div class="right-layout">
                        <form id="seatForm6" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S26" class="{{ in_array('S26', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S26</button>
                            <button type="submit" name="seat_number" value="S27" class="{{ in_array('S27', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S27</button>
                            <button type="submit" name="seat_number" value="S28" class="{{ in_array('S28', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S28</button>
                            <button type="submit" name="seat_number" value="S29" class="{{ in_array('S29', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S29</button>
                            <button type="submit" name="seat_number" value="S30" class="{{ in_array('S30', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S30</button>
                        </form>
                        <br>
                        <form id="seatForm6" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S35" class="{{ in_array('S35', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S35</button>
                            <button type="submit" name="seat_number" value="S34" class="{{ in_array('S34', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S34</button>
                            <button type="submit" name="seat_number" value="S33" class="{{ in_array('S33', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S33</button>
                            <button type="submit" name="seat_number" value="S32" class="{{ in_array('S32', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S32</button>
                            <button type="submit" name="seat_number" value="S31" class="{{ in_array('S31', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S31</button>
                        </form>
                        <br>
                        <form id="seatForm8" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S36" class="{{ in_array('S36', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S36</button>
                            <button type="submit" name="seat_number" value="S37" class="{{ in_array('S37', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S37</button>
                            <button type="submit" name="seat_number" value="S38" class="{{ in_array('S38', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S38</button>
                            <button type="submit" name="seat_number" value="S39" class="{{ in_array('S39', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S39</button>
                            <button type="submit" name="seat_number" value="S40" class="{{ in_array('S40', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S40</button>
                        </form>
                        <br>
                        <form id="seatForm9" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S45" class="{{ in_array('S45', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S45</button>
                            <button type="submit" name="seat_number" value="S44" class="{{ in_array('S44', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S44</button>
                            <button type="submit" name="seat_number" value="S43" class="{{ in_array('S43', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S43</button>
                            <button type="submit" name="seat_number" value="S42" class="{{ in_array('S42', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S42</button>
                            <button type="submit" name="seat_number" value="S41" class="{{ in_array('S41', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S41</button>
                        </form>
                            </br>
                        <form id="seatForm10" action="{{ route('seat_value') }}" method="POST">
                            @csrf
                            <button type="submit" name="seat_number" value="S46" class="{{ in_array('S46', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S46</button>
                            <button type="submit" name="seat_number" value="S47" class="{{ in_array('S47', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S47</button>
                            <button type="submit" name="seat_number" value="S48" class="{{ in_array('S48', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S48</button>
                                <button type="submit" name="seat_number" value="S49" class="{{ in_array('S49', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S49</button>
                        <button type="submit" name="seat_number" value="S50" class="{{ in_array('S50', $seatNumbers) ? 'red-seat' : 'green-seat' }}">S50</button>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
@endsection
