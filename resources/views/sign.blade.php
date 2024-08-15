@extends('layouts.app')
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Request for Sign-Off</h1>
    </div><!-- End Page Title -->
    <br>
    <form id="signform" action="{{ route('sign_form') }}" method="POST" enctype="multipart/form-data">
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

  
    <div class="card">
            <div class="card-body">
              <h5 class="card-title">Meaning of the colours</h5>
              <center>
              <span style = 'padding: 0.5rem 1rem' class="alert alert-danger alert-dismissible fade show"><i class="bi bi-star me-1"></i> Pending</span>
              <span style = 'padding: 0.5rem 1rem' class="alert alert-warning alert-dismissible fade show"><i class="bi bi-collection me-1"></i> Unresolved</span>
              <span style = 'padding: 0.5rem 1rem' class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-1"></i> Resolved</span>
              </center>
            </div>
          </div>
    
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
        @php
            // Separate items by status
            $resolvedItems = $signoff->filter(fn($item) => $item->s_result === 'resolved');
            $unresolvedItems = $signoff->filter(fn($item) => $item->s_result === 'unresolved');
            $noResultItems = $signoff->filter(fn($item) => empty($item->s_result));
        @endphp

        @foreach($noResultItems as $item) <!-- Red alerts -->
            @php
            $alertClass = 'alert-danger';
            $showEditAndDelete = true;
            @endphp
            <div class="alert {{ $alertClass }} alert-dismissible fade show" role="alert">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        @if (strlen($item->s_description) > 50)
                            {{ substr($item->s_description, 0, 50) }}...
                        @else
                            {{ $item->s_description }}
                        @endif
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-primary btn-sm me-2" onclick="openPopup('{{ route('signview', $item) }}')">View</button>
                        @if ($showEditAndDelete)
                            <button class="btn btn-secondary btn-sm me-2" onclick="openPopup('{{ route('signedit', $item) }}')">Edit</button>
                            <a href="{{ url('signd/'.$item->id) }}" onclick="return confirm('Are you sure you want to delete the request for lab sign-off?');">
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        @foreach($unresolvedItems as $item) <!-- Yellow alerts -->
            @php
            $alertClass = 'alert-warning';
            $showEditAndDelete = empty($item->s_result);;
            @endphp
            <div class="alert {{ $alertClass }} alert-dismissible fade show" role="alert">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        @if (strlen($item->s_description) > 50)
                            {{ substr($item->s_description, 0, 50) }}...
                        @else
                            {{ $item->s_description }}
                        @endif
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-primary btn-sm me-2" onclick="openPopup('{{ route('signview', $item) }}')">View</button>
                        @if ($showEditAndDelete)
                            <button class="btn btn-secondary btn-sm me-2" onclick="openPopup('{{ route('signedit', $item) }}')">Edit</button>
                            <a href="{{ url('signd/'.$item->id) }}" onclick="return confirm('Are you sure you want to delete the request for lab sign-off?');">
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        @foreach($resolvedItems as $item) <!-- Green alerts -->
            @php
            $alertClass = 'alert-success';
            $showEditAndDelete = empty($item->s_result);
            @endphp
            <div class="alert {{ $alertClass }} alert-dismissible fade show" role="alert">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        @if (strlen($item->s_description) > 50)
                            {{ substr($item->s_description, 0, 50) }}...
                        @else
                            {{ $item->s_description }}
                        @endif
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-primary btn-sm me-2" onclick="openPopup('{{ route('signview', $item) }}')">View</button>
                        @if ($showEditAndDelete)
                            <button class="btn btn-secondary btn-sm me-2" onclick="openPopup('{{ route('signedit', $item) }}')">Edit</button>
                            <a href="{{ url('signd/'.$item->id) }}" onclick="return confirm('Are you sure you want to delete the request for lab sign-off?');">
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</main>

<!-- Modal Structure -->
<div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="popupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popupModalLabel">Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body-content">
                <!-- Content will be loaded here by AJAX -->
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<script>
    function openPopup(url) {
        $.get(url, function(data) {
            $('#modal-body-content').html(data);
            var myModal = new bootstrap.Modal(document.getElementById('popupModal'), {
                keyboard: false
            });
            myModal.show();
        });
    }
</script>

@endsection
