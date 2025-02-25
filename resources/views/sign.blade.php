@extends('layouts.app')
@section('content')
<style>
    .form-querygroup {
        margin-bottom: 1rem;
    }
    .custom-file-label::after {
        content: 'Choose';
    }
    .custom-imagefile-upload {
        border: 1px solid #ced4da;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        border-radius: 4px;
        background: #e9ecef;
    }
    .btn-custom {
        background-color: #0040ff; 
        color: white; 
    }
    .btn-custom:hover {
        background-color: #0056b3; 
    }
    .form-control {
        border-radius: 4px;
    }
</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Request for Sign-Off</h1>
    </div><!-- End Page Title -->
    <br>
    <div class="card">
        <div class="card-body">
            <div class="container mt-5">
                <form id="signform" action="{{ route('sign_form') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-querygroup">
                      <label for="s_img">Image:</label>
                        <div class="input-group">
                            <label class="input-group-text custom-imagefile-upload" for="s_img">
                                <i class="bi bi-image"></i> Choose Image
                            </label>
                            <input type="file" id="s_img" name="s_img[]" accept="image/*" multiple class="form-control d-none">
                        </div>
                        <div id="file-names" class="mt-2"></div> <!-- Element to display file names -->
                    </div>
                    <div class="form-querygroup">
                        <label for="s_description">Explanation:</label>
                        <textarea id="s_description" name="s_description" class="form-control" required></textarea>
                    </div>
                    <div class="form-querygroup">
                        <label for="s_clink">Codeshare Link:</label>
                        <input type="url" id="s_clink" name="s_clink" class="form-control">
                    </div>
                    <div class="form-querygroup">
                        <input type="submit" value="Submit" class="btn btn-custom">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Meaning of the colours</h5>
            <center>
                <span style="padding: 0.5rem 1rem" class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-star me-1"></i> Pending
                </span>
                <span style="padding: 0.5rem 1rem" class="alert alert-warning alert-dismissible fade show">
                    <i class="bi bi-collection me-1"></i> Unresolved
                </span>
                <span style="padding: 0.5rem 1rem" class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-1"></i> Resolved
                </span>
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
            $resolvedItems = $signoff->filter(fn($item) => $item->s_result === 'resolved');
            $unresolvedItems = $signoff->filter(fn($item) => $item->s_result === 'unresolved');
            $noResultItems = $signoff->filter(fn($item) => empty($item->s_result));
        @endphp

        @foreach($noResultItems as $item) 
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

    document.getElementById('s_img').addEventListener('change', function(event) {
    const fileInput = event.target;
    const fileNamesContainer = document.getElementById('file-names');
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    const maxSizeMB = 2;
    const maxSizeKB = maxSizeMB * 1024; 
    fileNamesContainer.innerHTML = '';
    const files = fileInput.files;
    
    if (files.length > 0) {
        const validFileNames = [];
        const invalidFileNames = [];
        Array.from(files).forEach(file => {
            if (allowedTypes.includes(file.type)) {
                if (file.size <= maxSizeKB * 1024) { 
                    validFileNames.push(file.name);
                } else {
                    invalidFileNames.push(file.name);
                }
            } else {
                invalidFileNames.push(file.name);
            }
        });

        if (validFileNames.length > 0) {
            fileNamesContainer.innerHTML = `<p>Selected images: ${validFileNames.join(', ')}</p>`;
        }
        
        if (invalidFileNames.length > 0) {
            fileNamesContainer.innerHTML += `<p class="text-danger">The following files are invalid or exceed the size limit: ${invalidFileNames.join(', ')}</p>`;
        }
    } else {
        fileNamesContainer.innerHTML = '<p>No files selected.</p>';
    }
});
</script>

@endsection
