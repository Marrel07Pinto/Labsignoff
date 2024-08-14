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
        <h2>Sign-off Request View</h2>
        <p><strong>Seat Number:</strong> {{ $signview->s_seat }}</p>
        <p><strong>ScreenShots:</strong>
            <div class="image-container">
                @php
                    $images = json_decode($signview->s_img);
                @endphp

                @if(!empty($images))
                    @foreach($images as $image)
                        <img src="{{ asset('images/signoff_images/' . $image) }}" alt="Screenshot">
                        <br>
                    @endforeach
                @else
                    <p>No images uploaded</p>
                @endif
            </div>
        </p>
        <p style="text-align: justify;"><strong>Description:</strong> {{ $signview->s_description }}</p>
        <p><strong>Code Link:</strong> {{ $signview->s_clink }}</p>
        <p><strong>Status:</strong> {{ $signview->s_result }}</p>
        <p><strong>Teaching Assistance:</strong> {{ $signview->s_resolved_by }}</p>

        @if($signview->s_result === 'unresolved')
            <p><strong>Reason for not giving the lab sign-off:</strong> {{ $signview->s_reason }}</p>
        @endif

        <!-- Add more fields as necessary -->
    </div>
</body>
</html>
