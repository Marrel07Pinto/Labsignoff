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
        <h2>Sign View</h2>
        
        <p><Strong>ScreenShots : </strong>
        <div class = "image-container">
            <img src="{{ asset('images/signoff_images/' . $signview->s_img) }}" alt="Screenshot"></p>
        </div>
        <p><strong>Description :</strong> {{ $signview->s_description }}</p>
        <p><strong>Code Link :</strong> {{ $signview->s_clink }}</p>

        <!-- Add more fields as necessary -->
    </div>

</body>
</html>

