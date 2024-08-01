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
</style>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Raise a Query</h1>
    </div><!-- End Page Title -->
    <br>
    <form id="signform" action="{{ route('query_form') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="q_query">Query:</label>
        <textarea id="q_query" name="q_query" required></textarea><br><br>              
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
    @if($data->isEmpty())
        <p>No queries submitted yet.</p>
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
</script>
@endsection
