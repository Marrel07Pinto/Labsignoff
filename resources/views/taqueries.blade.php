@extends('layouts.ta')

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
        <section class="section" id="queriesSection">
            <div class="row flex-row flex-nowrap overflow-auto">
                @foreach($queriesGivenToTA as $group)
                    @if ($group['ta']->id == auth()->user()->id) 
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
                                        @if (empty($querydata->solution)) <!-- Filter out solved queries -->
                                            <a href="#" class="query-link" data-query="{{ $querydata->q_query }}" data-seat="{{ $querydata->q_seat }}" data-id="{{ $querydata->id }}" data-solution="{{ $querydata->solution }}">
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <button type="button" class="btn btn-dark btn-size">
                                                        <i class="bi bi-person"></i>&nbsp;{{ $querydata->q_seat }}
                                                    </button> 
                                                    {{ Str::limit($querydata->q_query, 30, '...') }}
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                @endforeach
            </div>
        </section>
    @else
        <p>No queries</p>
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
                <form id="resolveQueryForm" action="{{ route('query_solution') }}" method="POST">
                    @csrf
                    <input type="hidden" id="queryId" name="query_id">
                    <div class="form-group">
                        <label for="queryText">Query</label>
                        <textarea class="form-control" id="queryText" rows="3" readonly></textarea>
                    </div>
                    </br>
                    <div class="form-group">
                        <label for="resolvedStatus">Status</label>
                        <select class="form-control" id="resolvedStatus" name="status">
                            <option value="resolved">Resolved</option>
                        </select>
                    </div>
                    </br>
                    <div class="form-group">
                        <label for="solutionText">Solution</label>
                        <textarea class="form-control" id="solutionText" name="solution" rows="3" required></textarea>
                    </div>
                    </br>
                  <center><button type="submit" class="btn btn-primary">Submit</button></center>
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
        // Function to refresh the queries section
        function refreshQueries() {
            $.get('{{ route("refresh_queries") }}', function(data) {
                $('#queriesSection').html(data);
                // Re-bind the query-link click event handler after content update
                bindQueryLinkHandler();
            });
        }

        // Bind click event handler for query-link
        function bindQueryLinkHandler() {
            $('.query-link').click(function(event) {
                event.preventDefault(); // Prevent default link behavior

                var query = $(this).data('query');
                var id = $(this).data('id');

                // Update the query status to 'in-progress'
                $.ajax({
                    url: '{{ route("query_status") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        status: 'in-progress'
                    },
                    success: function() {
                        $('#queryText').val(query);
                        $('#queryId').val(id);
                        $('#queryModal').modal('show'); // Show the modal
                    }
                });
            });
        }

        // Handle form submission
        $('#resolveQueryForm').submit(function(event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function() {
                $('#queryModal').modal('hide'); // Hide the modal
                refreshQueries(); // Refresh queries after form submission
            });
        });

        // Handle modal close event to reset the query status
        $('#queryModal').on('hidden.bs.modal', function () {
            var queryId = $('#queryId').val();
            if (queryId) {
                $.ajax({
                    url: '{{ route("query_status") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: queryId,
                        status: null // Reset status to NULL
                    },
                    success: function() {
                        // Optionally handle success
                    }
                });
            }
        });

        // Initial binding of query-link handler
        bindQueryLinkHandler();

        // Set up periodic refresh of queries section
        setInterval(refreshQueries, 500); // Change to 10000 ms (10 seconds) or your preferred interval
    });

</script>
@endsection
