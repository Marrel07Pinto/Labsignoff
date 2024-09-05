
<!DOCTYPE html>
<html>
    <style>
        /* Reset default styles */
        body, h1, p, label, input, textarea {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* General body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f9;
            color: #333;
            line-height: 1.6;
        }

        /* Main container */
        .main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Page title */
        .pagetitle h1 {
            font-size: 24px;
            color: #007bff;
            margin-bottom: 20px;
        }

        /* Section */
        .section {
            padding: 20px;
        }

        /* Card styling */
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Form styling */
        form {
            display: flex;
            flex-direction: column;
        }

        /* Form fields */
        label {
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="radio"] {
            margin-right: 5px;
            
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 16px;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        /* Submit button */
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Alert messages */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 16px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        input#confusing,
        input#important {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 16px;
        }


    </style>
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
                        <br>
                        <input type="submit"class="btn btn-outline-primary" value="Submit and Logout">
                    </form>
                </div>
            </div>
            </section>           
        </main>
    </body>
</html>