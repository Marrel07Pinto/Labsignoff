@extends('layouts.ta')

@section('content')
<style>
    .btn-size {
        width: 25%;
        align-items: center;
        justify-content: center;
    }
    .sign-image {
        max-width: 100%;
        height: auto;
    }
    .reason-box, .marks-box {
        display: none; /* Hide by default */
    }
    .bg-danger-custom {
        background-color: #dc3545;
        color: white;
    }
</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Sign-Off Requests</h1>
    </div><!-- End Page Title -->
    <br>
    @if(!empty($signsGivenToTA))
        <section class="section" id="signsSection">
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
        <p>No sign-off requests</p>
    @endif
</main>

<!-- Modal Structure -->
<div class="modal fade" id="signform" tabindex="-1" role="dialog" aria-labelledby="signModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                @if (session('success'))
                    <script>
                        alert('{{ session('success') }}');
                    </script>
                @endif
                <form id="resolveSignForm" action="{{ route('sign_solution') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="signImage">Attached Images</label>
                        <div id="signImagebox"></div>
                    </div>
                    <br>
                    <input type="hidden" id="signId" name="sign_id">
                    <div class="form-group">
                        <label for="signText">Sign-Off Description</label>
                        <textarea class="form-control" id="signText" rows="3" readonly></textarea>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="status">Status</label><br>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="statusResolved" name="status" value="resolved">
                            <label class="form-check-label" for="statusResolved">
                                Resolved
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="statusUnresolved" name="status" value="unresolved">
                            <label class="form-check-label" for="statusUnresolved">
                                Unresolved
                            </label>
                        </div>
                    </div>
                    <br>
                    <div class="form-group marks-box" id="marksBox">
                        <label for="marksInput">Marks</label>
                        <input type="number" class="form-control" id="marksInput" name="marks" required>
                    </div>
                    <br>
                    <div class="form-group reason-box" id="reasonBox">
                        <label for="reasonText">Reason for not giving lab signoff</label>
                        <textarea class="form-control" id="reasonText" name="reason" rows="3"></textarea>
                    </div>
                    <br>
                    <center><button type="submit" class="btn btn-primary">Submit</button></center>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    function refreshSigns() {
        $.get('{{ route("refresh_signs") }}', function(data) {
            $('#signsSection').html(data);
            bindSignLinkHandler(); // Re-bind click handlers after updating the section
        });
    }

    function bindSignLinkHandler() {
        $('.sign-link').off('click').on('click', function(event) { 
            event.preventDefault();
            var description = $(this).data('description');
            var id = $(this).data('id');
            var images = $(this).data('images') || []; 

            $('#signText').val(description);
            $('#signId').val(id);
            $('#signImagebox').empty(); 

            if (images.length > 0) {
                images.forEach(function(img) {
                    var imgUrl = "{{ asset('images/signoff_images') }}/" + img;
                    var imgElement = '<img src="' + imgUrl + '?v=' + new Date().getTime() + '" class="img-fluid mb-2 sign-image" />';
                    $('#signImagebox').append(imgElement);
                });
                $('#signImagebox').show();
            } else {
                $('#signImagebox').hide();
            }

            $('#signform').modal('show');

            $.ajax({
                url: '{{ route("sign_status") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    status: 'in-progress'
                },
                success: function() {
                    // Optionally handle success
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error updating sign status:', textStatus, errorThrown);
                }
            });
        });
    }

    $('#resolveSignForm').submit(function(event) {
        event.preventDefault();

        if (!$('input[name="status"]:checked').val()) {
            alert('Please select a status.');
            return;
        }

        // Disable the marks input if unresolved is selected
        if ($('#statusUnresolved').is(':checked')) {
            $('#marksInput').prop('disabled', true);
        } else {
            $('#marksInput').prop('disabled', false);
        }

        $.post($(this).attr('action'), $(this).serialize(), function() {
            $('#signform').modal('hide');
            refreshSigns(); // Refresh signs after form submission
        });
    });

    $('input[name="status"]').change(function() {
        if ($('#statusResolved').is(':checked')) {
            $('#marksBox').show();
            $('#reasonBox').hide();
            $('#marksInput').prop('required', true); // Make marks input required
        } else if ($('#statusUnresolved').is(':checked')) {
            $('#marksBox').hide();
            $('#reasonBox').show();
            $('#marksInput').prop('required', false); // Marks input not required for unresolved
        } else {
            $('#marksBox').hide();
            $('#reasonBox').hide();
        }
    });

    $('#signform').on('hidden.bs.modal', function () {
        var signId = $('#signId').val();
        if (signId) {
            $.ajax({
                url: '{{ route("sign_status") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: signId,
                    status: null 
                },
                success: function() {
                    
                }
            });
        }
    });

    bindSignLinkHandler();

    function debounce(func, wait) {
        let timeout;
        return function() {
            clearTimeout(timeout);
            timeout = setTimeout(func, wait);
        };
    }
    const debouncedRefreshSigns = debounce(refreshSigns, 500); 
    setInterval(debouncedRefreshSigns, 1000); 
});
</script>
@endsection
