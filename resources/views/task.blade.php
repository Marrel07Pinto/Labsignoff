@php
    $user = auth()->user();
    $layout = $user && $user->role === 'TA' ? 'layouts.ta' : 'layouts.app';
@endphp

@extends($layout)

@section('content')
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="lab-details mt-3">
                <div class="card">
                    <div class="card-body">
                        @if($ldetail) 
                            <h5 class="card-title"><strong>{{ $ldetail->t_lab }}</strong></h5>
                            <label>Hint: {{ $ldetail->t_hint }}</label><br>
                            @if(!empty($filepaths))
                                <ul>
                                    @foreach ($filepaths as $path)
                                        @php
                                            $cleanedpath = ltrim($path, '/');
                                            $filenamewithnumbers = basename($cleanedpath);
                                            $filename = preg_replace('/^\d+_/', '', $filenamewithnumbers);
                                        @endphp
                                        <li>
                                            <a href="{{ asset($path) }}" download>
                                                {{ basename($filename) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No files available.</p>
                            @endif
                        @else
                            <p>Lab details not found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>                         
    </section>
</main>
@endsection
