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
    .image-container img {
        width: 400px; 
        height: auto; 
    }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit and update the sign-off request</h2>
        <form id="signform" action="{{ url('signupdate/'.$signedit->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <label for="s_img">Screenshot:</label> 
                <div class = "image-container">
                    <img src="{{ asset('images/signoff_images/' . $signedit->s_img) }}">
                </div>
                    <input type="file" id="s_img" value="{{ $signedit->s_img }}" name="s_img" accept="image/*"><br><br>
                    <label for="s_description">Explanation:</label>
                    <textarea id="s_description" name="s_description">{{ $signedit->s_description }}</textarea><br><br>
                    <label for="s_clink">Codeshare Link:</label>
                    <input type="text" id="s_clink" name="s_clink" value="{{ $signedit->s_clink }}"><br><br>
                    <button type="submit">Update </button>
            </form>
            @if (session('success'))
                <script>
                    alert('{{ session('success') }}');
                </script>
                
            @endif
        <!-- Add more fields as necessary -->
    </div>

</body>
</html>

