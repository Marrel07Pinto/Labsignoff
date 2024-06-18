@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html>
<head>
    
</head>
<body>
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Please select your seat</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Icons</li>
          <li class="breadcrumb-item active">Bootstrap</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
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
</section>
</main>
</body>
</html>
@endsection
