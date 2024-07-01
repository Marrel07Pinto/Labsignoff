@extends('layouts.seatgui')
@section('content')
<!DOCTYPE html>
<html>
    <body>
        <main id="main" class="main">

            <div class="pagetitle">
                <h1>Please select your seat</h1>
            </div><!-- End Page Title -->

            <section class="section">
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
