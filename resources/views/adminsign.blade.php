@extends('layouts.admin')

@section('content')
<style>
    .btn-size {
        width: 25%;
        align-items: center;
        justify-content: center;
    }
    .query-image {
        max-width: 100%;
        height: auto;
    }
    .alert {
        position: relative;
    }
    .btn-right {
        float: right;
    }
    .status-text {
        font-weight: bold;
    }
</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Sign-Off Requests</h1>
    </div><!-- End Page Title -->
    <br>
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
          <br>
    @if(!empty($signsGivenToTA))
        <section class="section">
            <div class="row flex-row flex-nowrap overflow-auto">
                @foreach($signsGivenToTA as $group)
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $group['ta']->name }}</h5>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Teaching Assistant</li>
                                </ol>
                                <br>
                                @foreach($group['signs'] as $signdata)
                                    @php
                                    $alertClass = !empty($signdata->s_result) ? (
                                            $signdata->s_result === 'resolved' ? 'alert-success' :
                                            ($signdata->s_result === 'unresolved' ? 'alert-warning' : 'alert-danger')
                                        ) : 'alert-danger';
                                    @endphp
                                    <a href="#" class="sign-link" 
                                       data-description="{{ $signdata->s_description }}" 
                                       data-id="{{ $signdata->id }}" 
                                       data-solution="{{ $signdata->s_solution }}" 
                                       data-reason="{{ $signdata->s_reason }}" 
                                       data-images="{{ json_encode($signdata->s_img ? json_decode($signdata->s_img) : []) }}"
                                       data-status="{{ $signdata->s_result }}">
                                        <div class="alert {{ $alertClass }} alert-dismissible fade show" role="alert">
                                            <button type="button" class="btn btn-dark btn-size">
                                                <i class="bi bi-person"></i>&nbsp;{{ $signdata->s_seat }}
                                            </button> 
                                            {{ Str::limit($signdata->s_description, 30, '...') }}
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @else
        <p>No sign-off requests.</p>
    @endif
</main>

<!-- Modal Structure -->
<div class="modal fade" id="signModal" tabindex="-1" role="dialog" aria-labelledby="signModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                @if (session('success'))
                    <script>
                        alert('{{ session('success') }}');
                    </script>
                @endif
                <form id="resolveSignForm">
                    @csrf
                    <div class="form-group">
                        <label for="signImage">Attached Images</label>
                        <div id="signImagebox"></div>
                    </div>
                    <input type="hidden" id="signId" name="sign_id">
                    <div class="form-group">
                        <label for="signText">Sign-Off Description</label>
                        <textarea class="form-control" id="signText" rows="3" readonly></textarea>
                    </div>
                    <br>
                    <div class="form-group">
                        <span id="statusText" class="status-text"></span>
                    </div>
                    <br>
                    <div class="form-group" id="reasonBox" style="display: none;">
                        <label for="reasonText">Reason for not giving lab signoff</label>
                        <textarea class="form-control" id="reasonText" name="reason" rows="3" readonly></textarea>
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
$(document).ready(function() {
    // Handle click on sign-link
    $('.sign-link').click(function(event) {
        event.preventDefault(); // Prevent default link behavior
        
        var description = $(this).data('description');
        var id = $(this).data('id');
        var reason = $(this).data('reason');
        var images = $(this).data('images') || [];
        var status = $(this).data('status');
        var alertBox = $(this).find('.alert');

        // Set the status text and show/hide elements accordingly
        var statusText = status === 'resolved' ? 'Status: Resolved' :
                          (status === 'unresolved' ? 'Status: Unresolved' : 'Status: Unknown');

        $('#signText').val(description);
        $('#signId').val(id);
        $('#statusText').text(statusText);

        if (status === 'resolved') {
            $('#reasonBox').hide();
        } else if (status === 'unresolved') {
            $('#solutionBox').hide();
            $('#reasonText').val(reason ? reason : 'No reason provided by the teaching assistance.');
            $('#reasonBox').show();
        }

        $('#signImagebox').empty(); 

        if (images.length > 0) {
            images.forEach(function(img) {
                var imgUrl = "{{ asset('images/signoff_images') }}/" + img;
                var imgElement = '<img src="' + imgUrl + '?v=' + new Date().getTime() + '" class="img-fluid mb-2 query-image" />';
                $('#signImagebox').append(imgElement);
            });
            $('#signImagebox').show();
        } else {
            $('#signImagebox').hide();
        }

        $('#signModal').modal('show');
    });
});
</script>

@endsection
