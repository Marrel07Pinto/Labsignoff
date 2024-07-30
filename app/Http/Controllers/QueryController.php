<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Seat;
use App\Models\Query;
use App\Models\User;

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

    public function showQueries() {
        $adminquerydata = User::select('id', 'name', 'email', 'password', 'u_num')
            ->where('u_num', 'like', 'TA-%')
            ->orderBy('id', 'asc')
            ->get();
    
        $qdata = Query::all();
        
        // Prepare the data to be passed to the view
        $queriesGroupedByTA = [];
        
        foreach ($adminquerydata as $index => $ta) {
            $queriesGroupedByTA[$index]['ta'] = $ta;
            $queriesGroupedByTA[$index]['queries'] = $qdata->filter(function ($query, $key) use ($index, $adminquerydata) {
                return $key % count($adminquerydata) == $index;
            });
        }
    
        // Determine if the current user is a TA
        $user = Auth::user();
        $TA = strpos($user->u_num, 'TA-') === 0;
    
        // Pass data to the view
        return view('adminquery', [
            'queriesGroupedByTA' => $queriesGroupedByTA,
            'TA' => $TA
        ]);
    }
}


