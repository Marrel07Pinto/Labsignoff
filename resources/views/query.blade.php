@extends('layouts.app')
@section('content')
<style>
    .alert {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-delete {
        margin-left: auto;
    }
   
   
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
</style>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Raise a Query</h1>
    </div><!-- End Page Title -->
    <br>
    <div class="card">
    <div class="card-body">
    <div class="container mt-5">
        <form id="signform" action="{{ route('query_form') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-querygroup">
                <label for="q_img">Image:</label>
                    <div class="input-group">
                        <label class="input-group-text custom-imagefile-upload" for="q_img">
                            <i class="bi bi-image"></i> Choose Image
                        </label>
                            <input type="file" id="q_img" name="q_img[]" accept="image/*" multiple class="form-control d-none">
                    </div>
                    <div id="file-names" class="mt-2"></div> 
                </div>
            <div class="form-querygroup">
                <label for="q_query">Query:</label>
                <textarea id="q_query" name="q_query" class="form-control" required></textarea>
            </div>
            <div class="form-querygroup">
                <input type="submit" value="Submit" class="btn btn-custom">
            </div>
        </form>
    </div>
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
    @if($data->isEmpty())
    <div class="card">
            <div class="card-body">
              <h5 class="card-title">No queries submitted yet.</h5>
            </div>
    </div>
    @else            
        @foreach($data->sortBy(function($query) { return empty($query->solution) ? 0 : 1; }) as $query) 
            @php
                $alertClass = !empty($query->solution) ? 'alert-success' : 'alert-danger';
            @endphp 
            <a href="#" class="query-link" data-query="{{ $query->q_query }}" data-seat="{{ $query->q_seat }}" data-id="{{ $query->id }}" data-solution="{{ $query->solution }}" data-resolved_by="{{ $query->resolved_by }}">
                <div class="alert {{$alertClass}} alert-dismissible fade show" role="alert">
                    {{ $query->q_query }}
                    @if($alertClass == 'alert-danger')
                        <a href="{{ route('query.delete', $query->id) }}" onclick="return confirm('Are you sure you want to delete this query?');">
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </a>
                    @endif
                </div>
            </a>
        @endforeach
    @endif
</main>

<div class="modal fade" id="queryModal" tabindex="-1" role="dialog" aria-labelledby="queryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form id="resolveQueryForm">
                    @csrf
                    <input type="hidden" id="queryId" name="query_id">
                    <div class="form-group">
                        <label for="queryText">Query</label>
                        <textarea class="form-control" id="queryText" rows="3" readonly></textarea>
                    </div>
                    </br>
                    <div class="form-group">
                        <label for="resolvedStatus">Status: Resolved</label>
                    </div>
                    </br>
                    <div class="form-group">
                        <label for="resolvedBy">Resolved by:</label>
                        <input type="text" class="form-control" id="resolvedBy" readonly>
                    </div>
                    <div class="form-group">
                        <label for="solutionText">Solution</label>
                        <textarea class="form-control" id="solutionText" name="solution" rows="3" readonly></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function(){
        $('.query-link').click(function(event){
            event.preventDefault(); // Prevent default link behavior
            var query = $(this).data('query');
            var solution = $(this).data('solution');
            var id = $(this).data('id');
            var resolvedBy = $(this).data('resolved_by');
            var alertBox = $(this).find('.alert');

            // Check if the alert box has the class 'alert-success'
            if (alertBox.hasClass('alert-success')) {
                $('#queryText').val(query);
                $('#queryId').val(id);
                $('#solutionText').val(solution ? solution : 'No solution provided.');
                $('#resolvedBy').val(resolvedBy ? resolvedBy : 'No resolver specified.');
                $('#queryModal').modal('show'); 
            }
        });
    });

    document.getElementById('q_img').addEventListener('change', function(event) {
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
