@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html>
    <body>
        <main id="main" class="main">

            <div class="pagetitle">
                <h1>Request for sign-off</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">Icons</li>
                        <li class="breadcrumb-item active">Bootstrap</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
            <form id="signform" action="{{route('sign_form') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="s_img">Image:</label>
                    <input type="file" id="s_img" name="s_img" accept="image/*"><br><br>
                <label for="s_description">Explanation:</label>
                    <textarea id="s_description" name="s_description" required></textarea><br><br>
                <label for="s_clink">Codeshare Link:</label>
                    <input type="text" id="s_clink" name="s_clink"><br><br>
                <input type="submit" value="Submit">
            </form>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <script>
                    alert('{{ session('success') }}');
                </script>
            @endif
        </main>
    </body>
</html>
@endsection


