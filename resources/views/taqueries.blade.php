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
    @if(empty($queriesgiventoTA))
        <p>No Teaching Assistance</p>
    @else
        <section class="section">
            <div class="row flex-row flex-nowrap overflow-auto">
                @foreach($queriesgiventoTA as $group)
                    @if ($group['ta']->id == auth()->user()->id) <!-- Only show queries for the logged-in TA -->
                        <div class="col-lg-6">
                            <div class="text-decoration-none">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $group['ta']->name }}</h5>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">Teaching Assistant</li>
                                        </ol>
                                        <br>
                                        @foreach($group['queries'] as $querydata)
                                            <a href="">
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <button type="button" class="btn btn-dark btn-size">
                                                    <i class="bi bi-person"></i>&nbsp;{{ $querydata->q_seat }}
                                                </button> 
                                                {{ Str::limit($querydata->q_query, 30, '...') }}
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
    @endif
</main>
@endsection
