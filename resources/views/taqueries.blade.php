@extends('layouts.ta')

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
    .bg-danger-custom {
        background-color: #dc3545;
        color: white;
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
                                        @php
                                            $queryLabNumber = $querydata->lab;
                                            $taLabNumber = auth()->user()->lab;
                                            $isHighlighted = $queryLabNumber < $taLabNumber;
                                        @endphp
                                        @if (empty($querydata->solution))
                                            <a href="#" class="query-link" 
                                               data-query="{{ $querydata->q_query }}" 
                                               data-seat="{{ $querydata->q_seat }}" 
                                               data-id="{{ $querydata->id }}" 
                                               data-images="{{ json_encode($querydata->q_img ? json_decode($querydata->q_img) : []) }}">
                                                <div class="alert alert-danger alert-dismissible fade show {{ $isHighlighted ? 'bg-danger-custom' : '' }}" role="alert">
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
<div class="modal fade" id="queryform" tabindex="-1" role="dialog" aria-labelledby="queryModalLabel" aria-hidden="true">
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
          <div class="form-group">
            <label for="queryImage">Attached Images</label>
            <div id="queryImagebox"></div>
          </div>
          <br>
          <input type="hidden" id="queryId" name="query_id">
          <div class="form-group">
            <label for="queryText">Query</label>
            <textarea class="form-control" id="queryText" rows="3" readonly></textarea>
          </div>
          <br>
          <div class="form-group">
            <label for="resolvedStatus">Status</label>
            <select class="form-control" id="resolvedStatus" name="status">
              <option value="resolved">Resolved</option>
            </select>
          </div>
          <br>
          <div class="form-group">
            <label for="solutionText">Solution</label>
            <textarea class="form-control" id="solutionText" name="solution" rows="3" required></textarea>
          </div>
          <br>
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
$(document).ready(function() {
    // Function to refresh the queries section
    function refreshQueries() {
        $.get('{{ route("refresh_queries") }}', function(data) {
            $('#queriesSection').html(data);
            bindQueryLinkHandler(); 
        });
    }

    // Track open queries in session storage
    function setQueryAsInProgress(id) {
        let openQueries = JSON.parse(sessionStorage.getItem('openQueries')) || [];
        if (!openQueries.includes(id)) {
            openQueries.push(id);
            sessionStorage.setItem('openQueries', JSON.stringify(openQueries));
        }
    }

    function removeQueryFromOpen(id) {
        let openQueries = JSON.parse(sessionStorage.getItem('openQueries')) || [];
        openQueries = openQueries.filter(queryId => queryId !== id);
        sessionStorage.setItem('openQueries', JSON.stringify(openQueries));
    }

    function resetinProgressQueries() {
        let openQueries = JSON.parse(sessionStorage.getItem('openQueries')) || [];
        if (openQueries.length > 0) {
            $.ajax({
                url: '{{ route("reset_in_progressqueries") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: openQueries
                },
                success: function() {
                    sessionStorage.removeItem('openQueries'); 
                    refreshQueries();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error resetting in-progress queries:', textStatus, errorThrown);
                }
            });
        }
    }

    function bindQueryLinkHandler() {
        $('.query-link').off('click').on('click', function(event) { 
            event.preventDefault();
            var query = $(this).data('query');
            var id = $(this).data('id');
            var images = $(this).data('images') || []; 
            $('#queryText').val(query);
            $('#queryId').val(id);
            $('#queryImagebox').empty(); 

            if (images.length > 0) {
                images.forEach(function(img) {
                    var imgUrl = "{{ asset('images/query_images') }}/" + img;
                    var imgElement = '<img src="' + imgUrl + '?v=' + new Date().getTime() + '" class="img-fluid mb-2 query-image" />';
                    $('#queryImagebox').append(imgElement);
                });
                $('#queryImagebox').show();
            } else {
                $('#queryImagebox').hide();
            }

            $('#queryform').modal('show');
            setQueryAsInProgress(id); 

            $.ajax({
                url: '{{ route("query_status") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    status: 'in-progress'
                },
                success: function() {
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error updating query status:', textStatus, errorThrown);
                }
            });
        });
    }

    $('#resolveQueryForm').submit(function(event) {
        event.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function() {
            $('#queryform').modal('hide');
            removeQueryFromOpen($('#queryId').val()); 
            refreshQueries(); 
        });
    });

    $('#queryform').on('hidden.bs.modal', function () {
        var queryId = $('#queryId').val();
        if (queryId) {
            $.ajax({
                url: '{{ route("query_status") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: queryId,
                    status: null 
                },
                success: function() {
                   
                }
            });
            removeQueryFromOpen(queryId); 
        }
    });

    bindQueryLinkHandler();

   
    function debounce(func, wait) {
        let timeout;
        return function() {
            clearTimeout(timeout);
            timeout = setTimeout(func, wait);
        };
    }
    const debouncedRefreshQueries = debounce(refreshQueries, 500); 
    setInterval(debouncedRefreshQueries, 1000);


    resetinProgressQueries();
});

</script>
@endsection
