@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html>
    <body>
        <main id="main" class="main">

            <div class="pagetitle">
                <h1>Queries</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">Icons</li>
                        <li class="breadcrumb-item active">Bootstrap</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
            <form id="queryform" action="{{ route('query_form') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="q_img">Image:</label>
                    <input type="file" id="q_img" name="q_img" accept="image/*"><br><br>
                <label for="q_description">Description:</label>
                    <textarea id="q_description" name="q_description" required></textarea><br><br>
                <label for="q_clink">Codeshare Link:</label>
                    <input type="text" id="q_clink" name="q_clink"><br><br>
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


