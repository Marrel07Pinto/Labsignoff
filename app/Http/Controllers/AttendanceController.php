<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lab;
use App\Models\Attendance;

class AttendanceController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $labnumber = auth()->user()->lab;
        $atten = Attendance::where('lab', $labnumber)->get();
        $totalstud = Lab::where('t_lab', $labnumber)->value('t_no_stds');
        $present = Attendance::where('lab', $labnumber)->where('atten', 'Present')->count();
        $partialPresent= Attendance::where('lab', $labnumber)->where('atten', 'Partial_Present')->count();
        $absent = Attendance::where('lab', $labnumber)->where('atten', 'Absent')->count();
        $abs = $totalstud - ($present + $partialPresent + $absent);
        $totalabsent = $absent + $abs;

        $teachrole = auth()->user()->role;
        $layout = $teachrole === 'ADMIN' ? 'layouts.admin' : 'layouts.ta';
        return view('attendance', compact('layout','totalstud','present','partialPresent','totalabsent'));

    }
    public function downloadCsv()
    {
        $labnumber = auth()->user()->lab;

        // Fetch attendance data for the current lab
        $attendanceRecords = Attendance::where('lab', $labnumber)
                                        ->whereIn('atten', ['present', 'partial_present'])
                                        ->get(['name', 'atten']);

        // Create a temporary CSV file
        $csvFileName = 'attendance_report.csv';
        $csvFilePath = storage_path('app/public/' . $csvFileName);

        // Open the file for writing
        $file = fopen($csvFilePath, 'w');

        // Add the CSV header
        fputcsv($file, ['Student', 'Attendance']);

        // Add the data rows
        foreach ($attendanceRecords as $record) {
            fputcsv($file, [$record->name, $record->atten]);
        }

        // Close the file
        fclose($file);

        // Return the response to download the file
        return response()->download($csvFilePath)->deleteFileAfterSend(true);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function attenupdate(Request $request, $id)
    {
        $request->validate([
            'attendance' => 'required|string|max:255',
        ]);
        $attendance = Attendance::findOrFail($id);
        $attendance->atten = $request->input('attendance');
        $attendance->save();
        return redirect()->route('taskupload')->with('success', 'Attendance updated successfully.');
    }
}
