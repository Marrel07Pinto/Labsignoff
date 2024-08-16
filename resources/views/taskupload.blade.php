@extends('layouts.admin')

@section('content')

<main id="main" class="main">
    <div class="container">

        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @php
          $labnumber = $user = auth()->user()->lab;
        @endphp
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Upload lab task</h5>
                <form action="{{ route('task_upload_form') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <h5><strong>{{$labnumber}}</strong></h5>      
                    </div>
                    </br>
                    <div class="form-group">
                        <label for="files">Upload PDF Files</label>
                        <input type="file" name="files[]" id="files" class="form-control" accept="application/pdf" multiple required>
                    </div>

                    <div class="form-group">
                        <label for="hints">Hints</label>
                        <textarea name="hints" id="hints" class="form-control" rows="4" placeholder="Enter hints here..." required></textarea>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        @forelse ($ldata as $item)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <a href="#" onclick="openPopup('{{ route('taskuploadedit', ['id' => $item->id]) }}')">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">
                                <strong>{{ $item->t_lab }}</strong>
                            </h5>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">No lab tasks found.</p>
            </div>
        @endforelse
    </div>

</main>
<div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="popupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popupModalLabel">Edit and Update</h5>
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
