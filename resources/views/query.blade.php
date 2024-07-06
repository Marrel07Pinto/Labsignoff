@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html>
    <body>
        <main id="main" class="main">

            <div class="pagetitle">
                <h1>Raise a Query</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item">Icons</li>
                        <li class="breadcrumb-item active">Bootstrap</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
            <form id="signform" action="{{route('query_form') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="q_query">Query:</label>
                <textarea id="q_query" name="q_query" required></textarea><br><br>              
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
            @if($data->isEmpty())
                <p>No queries submitted yet.</p>
            @else
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <th style="width: 80%;">Query</th>
                        <th style="width: 20%;">Delete</th>
                    </tr>
                    @foreach($data as $item)  
                        <tr>
                            <td>{{ $item->q_query }}</td>
                            <td>
                            <a href="{{ url('delete/'.$item->id) }}" onclick="return confirm('Are you sure you want to delete this query?');"><button>Delete</button></a></td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </main>
    </body>
</html>
@endsection


