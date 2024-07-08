<!DOCTYPE html>
<html>
<head>
    <title>Sign View</title>
    <style>
        /* Add some basic styling */
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            padding: 20px;
        }
        .image-container img {
        width: 400px; 
        height: auto; 
    }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sign-off request view</h2>
        <p><Strong>Seat Number : </strong> {{ $signview->s_seat }} </p>
        <p><Strong>ScreenShots : </strong>
        <div class = "image-container">
            <img src="{{ asset('images/signoff_images/' . $signview->s_img) }}" alt="Screenshot"></p>
        </div>
        <p style="text-align: justify;"><strong>Description :</strong> {{ $signview->s_description }}</p>
        <p><strong>Code Link :</strong> {{ $signview->s_clink }}</p>
        <p><strong>Sign-off given by :</strong> </p>

        <!-- Add more fields as necessary -->
    </div>

</body>
</html>

