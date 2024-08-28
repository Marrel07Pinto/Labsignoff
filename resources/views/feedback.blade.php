@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html>
    <body>
        <main id="main" class="main">
                <div class="pagetitle">
                    <h1><center>Feedback Form</center></h1>
                </div><!-- End Page Title -->
            <section class="section">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            <div class="card">
                <div class="card-body">
                    <form id="feedback_form" action="{{route('feedback_form') }}" method="POST">
                        @csrf
                        <p><label for="understanding">How well did you understand today's lesson?</label><br>
                        <input type="radio" id="understanding1" name="understanding" value="1" required> 1
                        <input type="radio" id="understanding2" name="understanding" value="2"> 2
                        <input type="radio" id="understanding3" name="understanding" value="3"> 3
                        <input type="radio" id="understanding4" name="understanding" value="4"> 4
                        <input type="radio" id="understanding5" name="understanding" value="5"> 5</p>
                        <br> 
                        <p><label for="confusing">Was there anything that was confusing or unclear?</label><br>
                        <input id="confusing" name="confusing" required></input></p>
                        <br>
                        <p><label for="interesting">What activities or discussions did you find most interesting/helpful?</label><br>
                        <textarea id="interesting" name="interesting" required></textarea></p>
                        <br>
                        <p><label for="engaging">What could I do to make the class more engaging?</label><br>
                        <textarea id="engaging" name="engaging" required></textarea></p>
                        <br>
                        <p><label for="important">What is the most important thing you learned today?</label><br>
                        <input id="important" name="important" required></input></p>
                        <br>
                        <p><label for="overall">Rate the overall lab</label>
                        <input type="radio" id="overall1" name="overall" value="1" required> 1
                        <input type="radio" id="overall2" name="overall" value="2"> 2
                        <input type="radio" id="overall3" name="overall" value="3"> 3
                        <input type="radio" id="overall4" name="overall" value="4"> 4
                        <input type="radio" id="overall5" name="overall" value="5"> 5
                        </p>
                        <br>
                        <p><label for="difficulty">Rate the difficulty level</label>
                        <input type="radio" id="difficulty1" name="difficulty" value="1" required> 1
                        <input type="radio" id="difficulty2" name="difficulty" value="2"> 2
                        <input type="radio" id="difficulty3" name="difficulty" value="3"> 3
                        <input type="radio" id="difficulty4" name="difficulty" value="4"> 4
                        <input type="radio" id="difficulty5" name="difficulty" value="5"> 5
                        </p>
                        <input type="submit"class="btn btn-outline-primary" value="Submit">
                    </form>
                </div>
            </div>
            </section>           
        </main>
    </body>
</html>
@endsection