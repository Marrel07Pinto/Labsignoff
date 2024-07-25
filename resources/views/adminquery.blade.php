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
    @if($adminquerydata->isEmpty())
        <p>No Teaching Assistance</p>
    @else
        <section class="section">
            <div class="row flex-row flex-nowrap overflow-auto">
                @foreach($adminquerydata as $index => $ta)
                    <div class="col-lg-6">
                        <a href="" class="text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $ta->name }}</h5>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Teaching Assistant</li>
                                    </ol>
                                    <br>
                                    @foreach($qdata as $key => $querydata)
                                        @if($key % count($adminquerydata) == $index)
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <button type="button" class="btn btn-dark btn-size">
                                                    <i class="bi bi-person"></i>&nbsp;{{ $querydata->q_seat }}
                                                </button> 
                                                {{ Str::limit($querydata->q_query, 30, '...') }}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</main>
@endsection
