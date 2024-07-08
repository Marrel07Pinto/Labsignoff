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
                <hr>
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
            @if($signoff->isEmpty())
                <p>No request as been raised for lab signoff</p>
            @else
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <th style="width: 60%;">Explanation</th>
                        <th style="width: 25%;">CodeLink</th>
                        <th style="width: 5%;">View</th>
                        <th style="width: 5%;">Edit</th>
                        <th style="width: 5%;">Delete</th>
                    </tr>
                    @foreach($signoff as $item)  
                        <tr>
                            <td>{{ $item->s_description }}</td>
                            <td>{{ $item->s_clink }}</td>
                            <td><button>View</button></td>
                            <td><button>Edit</button></td>
                            <td><a href="{{ url('signd/'.$item->id) }}" onclick="return confirm('Are you sure you want to delete the request for lab sign-off?');"><button>Delete</button></a></td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </main>
    </body>
</html>
@endsection


