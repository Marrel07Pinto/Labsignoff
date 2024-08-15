<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lab;

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
        $labname = $request->input('lab_id');
        $request->validate([
            'lab_id' => 'required|string',
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
        $task = new Lab();
        $task->users_id = $user_id;
        $task->t_lab = $request->input('lab_id');
        $task->t_file = json_encode($filepaths);
        $task->t_hint = $request->input('hints');
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
        $labname = $request->input('lab_id');
        $request->validate([
            'lab_id' => 'required|string',
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
        $edittask ->t_lab = $request->input('lab_id');
        $edittask ->t_file = json_encode($filepaths);
        $edittask ->t_hint = $request->input('hints');
        $edittask ->save();

        return redirect()->route('taskupload')->with('success', "Task uploaded successfully for {$labname}");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
