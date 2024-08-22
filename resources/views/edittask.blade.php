<!-- editlabtask.blade.php -->

<div class="container">
    <form action="{{ route('task_update_form', ['id' => $edittaskadmin->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="lab_id"><strong>{{ $edittaskadmin->t_lab }}</strong></label>
        </div>
        <br>
        
        <div class="form-group">
            <label for="files">Upload PDF Files</label>
            <input type="file" name="files[]" id="files" class="form-control" accept="application/pdf" multiple>
            @if($edittaskadmin->t_file)
                @php
                    $filepaths = json_decode($edittaskadmin->t_file, true);
                @endphp

                @if(is_array($filepaths))
                    <div class="mt-3">
                        <ul class="list-unstyled">
                            @foreach($filepaths as $path)
                                @php
                                    $cleanedpath = ltrim($path, '/');
                                    $filenamewithnumbers = basename($cleanedpath);
                                    $filename = preg_replace('/^\d+_/', '', $filenamewithnumbers);
                                @endphp
                                <li>
                                    <label>Previously uploaded filename <strong>{{ $filename }}</strong></label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif
        </div>

        <div class="form-group">
            <label for="hints">Hints</label>
            <textarea name="hints" id="hints" class="form-control" rows="4" required>{{ $edittaskadmin->t_hint }}</textarea>
        </div>
        <div class="form-group">
            <label for="hints">Total number of students in lab</label>
            <input name="nostd" id="nostd" class="form-control" rows="4" value = "{{ $edittaskadmin->t_no_stds }}" required></input>
        </div>
         <label> Time for lab : <strong>{{$edittaskadmin->date_time}}</strong> </label>
        </br>
        <div class="form-group">
            <label for="date">Select Date:</label>
            <input type="date" id="date" name="date" class="form-control">
        </div>

        <div class="form-group">
            <label for="time">Select Time:</label>
            <input type="time" id="time" name="time" class="form-control">
        </div>

        <br>
        <div class="row">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>

    <form action="{{ route('edittaskadmin.delete', $edittaskadmin->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete the request for lab sign-off?');">
        @csrf
        @method('DELETE')
        <br>
        <div class="row">
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </div>
    </form>
</div>
