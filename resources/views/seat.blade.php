<!DOCTYPE html>
<html>
<head>
    <title>Seat Selection</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        function confirmSeatSelection(event) {
            if (!confirm("Your seat is " + seatNumber)) {
                event.preventDefault(); 
            }
        }
    </script>
</head>
<body>
    <form id="seatForm" action="{{ route('seat_value') }}" method="POST">
        @csrf
        <button type="submit" name="seat_number" value="S1" onclick="confirmSeatSelection(event)">S1</button>
        <button type="submit" name="seat_number" value="S2" onclick="confirmSeatSelection(event)">S2</button>
        <button type="submit" name="seat_number" value="S3" onclick="confirmSeatSelection(event)">S3</button>
        <button type="submit" name="seat_number" value="S4" onclick="confirmSeatSelection(event)">S4</button>
        <button type="submit" name="seat_number" value="S5" onclick="confirmSeatSelection(event)">S5</button>
    </form>
    <br>
    <form id="seatForm2" action="{{ route('seat_value') }}" method="POST">
        @csrf
        <button type="submit" name="seat_number" value="S10" onclick="confirmSeatSelection(event)">S10</button>
        <button type="submit" name="seat_number" value="S9" onclick="confirmSeatSelection(event)">S9</button>
        <button type="submit" name="seat_number" value="S8" onclick="confirmSeatSelection(event)">S8</button>
        <button type="submit" name="seat_number" value="S7" onclick="confirmSeatSelection(event)">S7</button>
        <button type="submit" name="seat_number" value="S6" onclick="confirmSeatSelection(event)">S6</button>
    </form>
</body>
</html>
