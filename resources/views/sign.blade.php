@extends('layouts.app')
@section('content')

        <main id="main" class="main">
            <div class="pagetitle">
                <h1>Request for sign-off</h1>
            </div><!-- End Page Title -->
            <br>
            <form id="signform" action="{{route('sign_form') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="s_img">Image:</label>
                    <input type="file" id="s_img" name="s_img[]" accept="image/*" multiple><br><br>
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
                <p>No request has been raised for lab sign-off</p>
            @else
            @foreach($signoff as $item)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                @if (strlen($item->s_description) > 50)
                                    {{ substr($item->s_description, 0, 50) }}...
                                @else
                                    {{ $item->s_description }}
                                @endif
                            </div>
                            <div class="d-flex">
                                <a href="#" onclick="openPopup('{{ route('signview', $item) }}')">
                                    <button class="btn btn-primary btn-sm me-2">View</button>
                                </a>
                                <a href="#" onclick="openPopup('{{ route('signedit', $item) }}')">
                                    <button class="btn btn-secondary btn-sm me-2">Edit</button>
                                </a>
                                <a href="{{ url('signd/'.$item->id) }}" onclick="return confirm('Are you sure you want to delete the request for lab sign-off?');">
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </a>
                            </div>
                        </div>
                    </div>
                 @endforeach
            @endif
        </main>
        <script>
            function openPopup(url) 
            {
            window.open(url, 'popupWindow', 'width=600,height=400,scrollbars=yes');
            }
        </script>
@endsection


