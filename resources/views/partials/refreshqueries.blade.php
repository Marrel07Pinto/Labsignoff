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
                                        <!-- Container for images in the queries section -->
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
