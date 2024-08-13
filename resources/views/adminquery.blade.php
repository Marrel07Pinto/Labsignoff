@extends('layouts.admin')
@section('content')
<style>
    .btn-size {
        width: 25%;
        align-items: center;
        justify-content: center;
    }
</style>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Raised Queries</h1>
    </div><!-- End Page Title -->
    </br>
    @if(!empty($queriesGivenToTA))
        <section class="section">
            <div class="row flex-row flex-nowrap overflow-auto">
                @foreach($queriesGivenToTA as $group)
                    <div class="col-lg-6">
                        <a class="text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $group['ta']->name }}</h5>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Teaching Assistant</li>
                                    </ol>
                                    <br>
                                    @foreach($group['queries'] as $querydata)
                                        @php
                                            $alertClass = !empty($querydata->solution) ? 'alert-success' : 'alert-danger';
                                        @endphp
                                        <a href="#" class="query-link" data-query="{{ $querydata->q_query }}" data-seat="{{ $querydata->q_seat }}" data-id="{{ $querydata->id }}" data-solution="{{ $querydata->solution }}" data-images="{{ json_encode($querydata->q_img ? json_decode($querydata->q_img) : []) }}">
                                            <div class="alert {{ $alertClass }} alert-dismissible fade show" role="alert">
                                                <button type="button" class="btn btn-dark btn-size">
                                                    <i class="bi bi-person"></i>&nbsp;{{ $querydata->q_seat }}
                                                </button> 
                                                {{ Str::limit($querydata->q_query, 30, '...') }}
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @else
        <p>No teaching assistance.</p>
    @endif
</main>
<!-- Modal Structure -->
<div class="modal fade" id="queryModal" tabindex="-1" role="dialog" aria-labelledby="queryModalLabel" aria-hidden="true">
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
                        <label for="queryImage">Attached Images</label>
                        <div id="queryImagebox"></div>
                    </div>
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
            var images = $(this).data('images') || [];
            var alertBox = $(this).find('.alert');

            // Check if the alert box has the class 'alert-success'
            if (alertBox.hasClass('alert-success')) {
                $('#queryText').val(query);
                $('#queryId').val(id);
                $('#solutionText').val(solution ? solution : 'No solution provided.');
                $('#queryImagebox').empty(); 
                if (images.length > 0) {
                images.forEach(function(img) 
                {
                    var imgUrl = "{{ asset('images/query_images') }}/" + img;
                    var imgElement = '<img src="' + imgUrl + '?v=' + new Date().getTime() + '" class="img-fluid mb-2 query-image" />';
                    $('#queryImagebox').append(imgElement);
                });
                    $('#queryImagebox').show();
                } 
                else 
                {
                    $('#queryImagebox').hide();
                }

                $('#queryModal').modal('show'); 
            }
        });
    });
</script>
@endsection
