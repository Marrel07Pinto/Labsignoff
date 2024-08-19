<div class="row flex-row flex-nowrap overflow-auto">
    @foreach($signsGivenToTA as $group)
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
                        @foreach($group['signs'] as $signdata)
                        @php
                            $signLabNumber = $signdata->lab;
                            $taLabNumber = auth()->user()->lab;
                            $isHighlighted = $signLabNumber < $taLabNumber;
                        @endphp
                            @if ($signdata->s_result !== 'resolved' && $signdata->s_result !== 'unresolved')
                                <a href="#" class="sign-link" 
                                   data-description="{{ $signdata->s_description }}" 
                                   data-id="{{ $signdata->id }}" 
                                   data-solution="{{ $signdata->s_solution }}" 
                                   data-images="{{ json_encode($signdata->s_img ? json_decode($signdata->s_img) : []) }}">
                                   <div class="alert alert-danger alert-dismissible fade show {{ $isHighlighted ? 'bg-danger-custom' : '' }}" role="alert">
                                        <button type="button" class="btn btn-dark btn-size">
                                            <i class="bi bi-person"></i>&nbsp;{{ $signdata->s_seat }}
                                        </button> 
                                        {{ Str::limit($signdata->s_description, 30, '...') }}
                                        <!-- Container for images in the sign section -->
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
