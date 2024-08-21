<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lab;
use Carbon\Carbon;

class TaskuploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $labname = auth()->user()->lab;
        $request->validate([
            'files.*' => 'required|file|mimes:pdf|max:2048',
            'hints' => 'nullable|string|max:255',
        ]);

        $filepaths = [];

        // Check if files are present and process them
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $filepath = $file->move(public_path('/labtask'), $filename);
                $filepaths[] = '/labtask/' . $filename;
            }
        }

        $date = $request->input('date');
        $time = $request->input('time');
        $datetimestring = $date . ' ' . $time; 
        $datetetime = Carbon::parse($datetimestring);

        $task = new Lab();
        $task->users_id = $user_id;
        $task->t_lab = $labname;
        $task->t_file = json_encode($filepaths);
        $task->t_hint = $request->input('hints');
        $task->date_time = $datetetime;
        $task->save();

        return redirect()->route('taskupload')->with('success', "Task uploaded successfully for {$labname}");
    }

        
    

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user_id = auth()->user()->id;
        $ldata = Lab::where('users_id', $user_id)->get();
        return view('taskupload', compact('ldata'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edittaskadmin = Lab::find($id);
        return view('edittask',compact('edittaskadmin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $edittask = Lab::find($id);
        
        $request->validate([
            'files.*' => 'nullable|file|mimes:pdf|max:2048',
            'hints' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
        ]);
    
        // Preserve existing values
        $filepaths = json_decode($edittask->t_file, true) ?? [];
    
        // Check if new files are provided
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $filepath = $file->move(public_path('/labtask'), $filename);
                $filepaths[] = '/labtask/' . $filename;
            }
        }
    
        if ($request->filled('date') && $request->filled('time')){
            $date = $request->input('date');
            $time = $request->input('time');
            $datetimestring = $date . ' ' . $time;
            $datetetime = Carbon::parse($datetimestring);
            $edittask->date_time = $datetetime;
        }
        // Update only the fields that are present in the request
        if ($request->has('hints')) {
            $edittask->t_hint = $request->input('hints');
        }
        
        // Update files if new ones were uploaded
        if (!empty($filepaths)) {
            $edittask->t_file = json_encode($filepaths);
        }
    
        // Save the updated task
        $edittask->save();
    
        return redirect()->route('taskupload')->with('success', "Task updated successfully for {$edittask->t_lab}");
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $labd = Lab::find($id);
        $labd->delete();
        return back()->with('success', 'deleted successfully!');
    }
    
    public function labdetails()
{
    $labnumber = auth()->user()->lab;
    $ldetail = Lab::where('t_lab', $labnumber)->first();
    $filepaths = $ldetail ? json_decode($ldetail->t_file) : [];
    return view('task', compact('ldetail', 'filepaths'));
}

    
    
   

}
