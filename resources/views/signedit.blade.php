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
    <main>
        <div class="container">
            <h2>Edit and update the sign-off request</h2>
            <form id="signform" action="{{ url('signupdate/'.$signedit->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <label for="s_img">Current Screenshots:</label> 
                        <div class="image-container">
                            @php
                                $images = json_decode($signedit->s_img);
                            @endphp

                            @if(!empty($images))
                                @foreach($images as $image)
                                    <img src="{{ asset('images/signoff_images/' . $image) }}" alt="Screenshot" style="width: 100px; height: auto;">
                                @endforeach
                            @else
                                <p>No images available.</p>
                            @endif
                        </div>
                    <label for="s_img">Upload New Screenshots:</label>
                    <input type="file" id="s_img" name="s_img[]" accept="image/*" multiple>
                    <br>
                    <label for="s_description">Explanation:</label></br>
                    <textarea id="s_description" name="s_description">{{ $signedit->s_description }}</textarea><br>
                    <br>
                    <label for="s_clink">Codeshare Link:</label></br>
                    <input type="text" id="s_clink" name="s_clink" value="{{ $signedit->s_clink }}"><br>
                    <br>
                    <button type="submit">Update </button>
                </form>
                @if (session('success'))
                    <script>
                        alert('{{ session('success') }}');
                    </script>
                    
                @endif
            <!-- Add more fields as necessary -->
        </div>
    </main>
</body>
</html>

