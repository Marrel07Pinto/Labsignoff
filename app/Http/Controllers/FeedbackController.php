<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
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
        $feedback = new Feedback();
        $feedback->f_understanding = $request->input('understanding');
        $feedback->f_confusing = $request->input('confusing');
        $feedback->f_interesting =$request->input('interesting');
        $feedback->f_engaging = $request->input('engaging');
        $feedback->f_important = $request->input('important');
        $feedback->f_overall = $request->input('overall');
        $feedback->f_difficulty = $request->input('difficulty');
        $feedback->save();
        return back()->with('success', 'Feedback submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
