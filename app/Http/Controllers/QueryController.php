<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;
use App\Models\Query;

class QueryController extends Controller
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
        $seat = Seat::where('users_id', $user_id)->first();
        $seat_number = $seat->seat_num;

        $query = new Query();
        $query->users_id = $user_id;
        $query->q_seat = $seat_number;
        $query->q_query=$request->input('q_query');
        $query->save();
        return back()->with('success', 'Query has been raised successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user_id = auth()->user()->id;
        $data = Query::where('users_id', $user_id)->get();
        return view('query',compact('data'));
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
    public function destroy($id)
    {
        $data = Query::find($id);
        $data->delete();
        return back()->with('success', 'Query has been deleted successfully!');
    }
}
