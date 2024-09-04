@extends($layout)

@section('content')

<main id="main" class="main">
    <div class="pagetitle">                
        <div class="card">
            <div class="card-body">
                <br>
                <h1><center>STUDENT DATA</center></h1>  
                <br>
                @if(isset($error) && !empty($error))
                    <p><strong>{{ $error }}</strong></p>
                @else
                    <label><strong>Student Name :</strong>  {{$username}} </label><br>
                    <br>
                    <label><strong>University Number :</strong>  {{$usernum}} </label><br>
                    <br>
                    <h5 class="card-title">QUERY DATA</h5>
                    @if($queries->isNotEmpty())
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Seat</th>
                                    <th>Query</th>
                                    <th>State</th>
                                    <th>Resolved By</th>
                                    <th>Solution</th>
                                    <th>Lab</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($queries as $query)
                                    <tr>
                                        <td>{{ $query->q_seat }}</td>
                                        <td>{{ $query->q_query }}</td>
                                        <td>{{ $query->q_state }}</td>
                                        <td>{{ $query->resolved_by }}</td>
                                        <td>{{ $query->solution }}</td>
                                        <td>{{ $query->lab }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No queries found for this user.</p>
                    @endif
                    <br><br>
                    <h5 class="card-title">SIGN OFF REQUEST</h5>
                    @if($sign_off->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Lab</th>
                                    <th scope="col">Link for the code</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Resolved By</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Marks</th>
                                    <th scope="col">Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sign_off as $sign)
                                    <tr>
                                        <td>{{ $sign->lab }}</td>
                                        <td>{{ $sign->s_clink }}</td>
                                        <td>{{ Str::limit($sign->s_description, 12, '...') }}</td>
                                        <td>{{ $sign->s_resolved_by }}</td>
                                        <td>{{ $sign->s_result }}</td>
                                        <td>{{ $sign->marks }}</td>
                                        <td>
                                            <a href="#" class="edit-signoff" data-bs-toggle="modal" data-bs-target="#editSignOffModal" 
                                               data-id="{{ $sign->id }}" 
                                               data-resolved-by="{{ $sign->s_resolved_by }}" 
                                               data-result="{{ $sign->s_result }}" 
                                               data-marks="{{ $sign->marks }}" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No sign off requests found for this user.</p>
                    @endif
                    <br><br>        
                    <h5 class="card-title">ATTENDANCE</h5>
                    @if($atten->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Lab</th>
                                    <th scope="col">Attendance</th> 
                                    <th scope="col">Edit</th>                                 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($atten as $attendance)
                                    <tr>
                                        <td>{{ $attendance->lab }}</td>
                                        <td>{{ $attendance->atten }}</td>
                                        <td>
                                            <a href="#" class="edit-attendance" data-bs-toggle="modal" data-bs-target="#editAttendanceModal" 
                                               data-id="{{ $attendance->id }}" 
                                               data-attendance="{{ $attendance->atten }}" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No attendance tracked</p>
                    @endif
                @endif
            </div>
        </div>
    </div>
</main>

<!-- Edit Sign Off Modal -->
<div class="modal fade" id="editSignOffModal" tabindex="-1" aria-labelledby="editSignOffModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSignOffModalLabel">Edit Sign Off Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSignOffForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editResolvedBy" class="form-label">Resolved By</label>
                        <input type="text" class="form-control" id="editResolvedBy" name="resolved_by" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label><br>
                        <input type="radio" id="editStatusResolved" name="result" value="Resolved">
                        <label for="editStatusResolved">Resolved</label><br>
                        <input type="radio" id="editStatusUnresolved" name="result" value="Unresolved">
                        <label for="editStatusUnresolved">Unresolved</label>
                    </div>
                    <div class="mb-3" id="marksInput">
                        <label for="editMarks" class="form-label">Marks</label>
                        <input type="number" class="form-control" id="editMarks" name="marks" >
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Attendance Modal -->
<div class="modal fade" id="editAttendanceModal" tabindex="-1" aria-labelledby="editAttendanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAttendanceModalLabel">Edit Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAttendanceForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Attendance</label><br>
                        <input type="radio" id="editAttendanceAbsent" name="attendance" value="Absent">
                        <label for="editAttendanceAbsent">Absent</label><br>
                        <input type="radio" id="editAttendancePartial" name="attendance" value="Partial_Present">
                        <label for="editAttendancePartial">Partial Present</label><br>
                        <input type="radio" id="editAttendancePresent" name="attendance" value="Present">
                        <label for="editAttendancePresent">Present</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle Sign Off Edit
        var editSignOffModal = document.getElementById('editSignOffModal');
        editSignOffModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var resolvedBy = button.getAttribute('data-resolved-by');
            var result = button.getAttribute('data-result');
            var marks = button.getAttribute('data-marks');

            // Populate the form fields with the data from the button
            editSignOffModal.querySelector('#editResolvedBy').value = resolvedBy;
            editSignOffModal.querySelector('#editMarks').value = marks;

            // Set the result radio button
            if (result === 'Resolved') {
                editSignOffModal.querySelector('#editStatusResolved').checked = true;
                editSignOffModal.querySelector('#marksInput').style.display = 'block';
            } else {
                editSignOffModal.querySelector('#editStatusUnresolved').checked = true;
                editSignOffModal.querySelector('#marksInput').style.display = 'none';
            }

            // Update the form action to point to the correct route
            var form = editSignOffModal.querySelector('#editSignOffForm');
            form.action = '/signoff-update/' + id; // Update with your correct update route
        });

        // Toggle marks input based on the status selection
        var editStatusResolved = document.getElementById('editStatusResolved');
        var editStatusUnresolved = document.getElementById('editStatusUnresolved');
        var marksInput = document.getElementById('marksInput');

        editStatusResolved.addEventListener('change', function() {
            marksInput.style.display = 'block';
        });

        editStatusUnresolved.addEventListener('change', function() {
            marksInput.style.display = 'none';
        });

        // Handle Attendance Edit
        var editAttendanceModal = document.getElementById('editAttendanceModal');
        editAttendanceModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var attendance = button.getAttribute('data-attendance');

            // Populate the form fields with the data from the button
            editAttendanceModal.querySelector('#editAttendanceAbsent').checked = attendance === 'Absent';
            editAttendanceModal.querySelector('#editAttendancePartial').checked = attendance === 'Partial_Present';
            editAttendanceModal.querySelector('#editAttendancePresent').checked = attendance === 'Present';

            // Update the form action to point to the correct route
            var form = editAttendanceModal.querySelector('#editAttendanceForm');
            form.action = '/attendance-update/' + id; // Update with your correct update route
        });
    });
</script>

@endsection
