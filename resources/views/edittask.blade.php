<!-- editlabtask.blade.php -->

<div class="container">
    <form action="{{ route('task_update_form', ['id' => $edittaskadmin->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="lab_id">Select Lab</label>
            <select name="lab_id" id="lab_id" class="form-control" required>
                <option value="">Select a Lab</option>
                @for ($i = 1; $i <= 15; $i++)
                    <option value="lab{{ $i }}" {{ $edittaskadmin->t_lab === "lab$i" ? 'selected' : '' }}>
                        Lab {{ $i }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label for="files">Upload PDF Files</label>
            <input type="file" name="files[]" id="files" class="form-control" accept="application/pdf" multiple>
            <!-- Display previously uploaded files -->
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
                                   <label>Previously uploaded filename <strong>{{ $filename }}</strong> </label>
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
        
        <br>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
