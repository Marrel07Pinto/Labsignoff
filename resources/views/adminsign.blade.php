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
</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Raised Queries</h1>
    </div><!-- End Page Title -->
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
                                        $alertClass = !empty($signdata->s_solution) ? 'alert-success' : 'alert-danger';
                                    @endphp
                                    <a href="#" class="query-link" 
                                       data-query="{{ $signdata->s_description }}" 
                                       data-seat="{{ $signdata->s_seat }}" 
                                       data-id="{{ $signdata->id }}" 
                                       data-solution="{{ $signdata->s_solution }}" 
                                       data-images="{{ json_encode($signdata->s_img ? json_decode($signdata->s_img) : []) }}">
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
        <p>No teaching assistance.</p>
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
                <form id="resolveQueryForm">
                    @csrf
                    <div class="form-group">
                        <label for="signImage">Attached Images</label>
                        <div id="signImagebox"></div>
                    </div>
                    <input type="hidden" id="signId" name="sign_id">
                    <div class="form-group">
                        <label for="signText">Query</label>
                        <textarea class="form-control" id="signText" rows="3" readonly></textarea>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="resolvedStatus">Status: Resolved</label>
                    </div>
                    <br>
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
        
        // Determine the alert class to check if it's a resolved query
        var alertClass = $(this).find('.alert').attr('class');
        
        // Proceed only if the alert class contains 'alert-success' indicating resolved queries
        if (alertClass.includes('alert-success')) {
            var query = $(this).data('query');
            var solution = $(this).data('solution');
            var id = $(this).data('id');
            var images = $(this).data('images') || [];

            $('#signText').val(query);
            $('#signId').val(id);

            // Display the solution text or a default message
            $('#solutionText').val(solution ? solution : 'No solution provided.');

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
        } else {
            // Optionally handle cases where the alert class is not 'alert-success'
            console.log('Query is not resolved, modal will not appear.');
        }
    });
});
</script>
@endsection
