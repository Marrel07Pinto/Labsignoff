<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    public function query_solution(Request $request)
    {
        $query = Query::find($request->input('query_id'));
        if ($query) {
            $query->resolved_by = auth()->user()->name;
            $query->solution = $request->input('solution'); 
            $query->save();
        }
        
        return redirect()->back()->with('success', 'Query resolved successfully.');
    
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
        // Fetch all TAs
        $querydata = User::select('id', 'name', 'email', 'password', 'u_num')
                         ->where('u_num', 'like', 'TA-%')
                         ->orderBy('id', 'asc')
                         ->get();
        
        // Fetch all queries
        $qdata = Query::all();
        
        // Prepare the data to be passed to the view
        $queriesGivenToTA = [];
        
        // Initialize the array for queries per TA
        $taQueries = [];

        $pendingQueries = [];
    
    // Get the list of TA names for quick lookup
         $taNames = $querydata->pluck('name')->toArray();
        
        // Assign queries based on `resolved_by`
        foreach ($querydata as $ta) {
            $taQueries[$ta->id] = collect();
        }
        
        foreach ($qdata as $query) {
            if (!empty($query->resolved_by)) {
                // Check if the resolved_by TA exists
                if (in_array($query->resolved_by, $taNames)) {
                    // Get the TA object
                    $ta = $querydata->firstWhere('name', $query->resolved_by);
                    if ($ta) {
                        // Add query to the TA's list
                        $taQueries[$ta->id][] = $query;
                        continue; // Skip to the next query
                    }
                } else {
                    // If resolved_by TA does not exist, do not distribute this query
                    continue;
                }
            }
            // If resolved_by TA not found or empty, add to pending queries for distribution
            $pendingQueries[] = $query;
        }
        
        // Distribute remaining queries
        $taIds = $querydata->pluck('id')->toArray();
        $taCount = count($taIds);
        
        if ($taCount > 0 && !empty($pendingQueries)) {
            $taIndex = 0;
            foreach ($pendingQueries as $query) {
                $taId = $taIds[$taIndex % $taCount];
                $taQueries[$taId][] = $query;
                $taIndex++;
            }
        }
        
        // Prepare data for view
        foreach ($querydata as $index => $ta) {
            $queriesGivenToTA[$index]['ta'] = $ta;
            $queriesGivenToTA[$index]['queries'] = $taQueries[$ta->id];
        }
        
        return view('adminquery', compact('queriesGivenToTA'));
    }
    

    public function taQueries() {
        $querydata = User::select('id', 'name', 'email', 'password', 'u_num')
        ->where('u_num', 'like', 'TA-%')
        ->orderBy('id', 'asc')
        ->get();

            // Fetch all queries
            $qdata = Query::all();

            // Prepare the data to be passed to the view
            $queriesGivenToTA = [];

            // Initialize the array for queries per TA
            $taQueries = [];

            $pendingQueries = [];

            // Get the list of TA names for quick lookup
            $taNames = $querydata->pluck('name')->toArray();

            // Assign queries based on `resolved_by`
            foreach ($querydata as $ta) {
            $taQueries[$ta->id] = collect();
            }

            foreach ($qdata as $query) {
            if (!empty($query->resolved_by)) {
            // Check if the resolved_by TA exists
            if (in_array($query->resolved_by, $taNames)) {
            // Get the TA object
            $ta = $querydata->firstWhere('name', $query->resolved_by);
            if ($ta) {
                // Add query to the TA's list
                $taQueries[$ta->id][] = $query;
                continue; // Skip to the next query
            }
            } else {
            // If resolved_by TA does not exist, do not distribute this query
            continue;
            }
            }
            // If resolved_by TA not found or empty, add to pending queries for distribution
            $pendingQueries[] = $query;
            }

            // Distribute remaining queries
            $taIds = $querydata->pluck('id')->toArray();
            $taCount = count($taIds);

            if ($taCount > 0 && !empty($pendingQueries)) {
            $taIndex = 0;
            foreach ($pendingQueries as $query) {
            $taId = $taIds[$taIndex % $taCount];
            $taQueries[$taId][] = $query;
            $taIndex++;
            }
            }

            // Prepare data for view
            foreach ($querydata as $index => $ta) {
            $queriesGivenToTA[$index]['ta'] = $ta;
            $queriesGivenToTA[$index]['queries'] = $taQueries[$ta->id];
            }

            return view('taqueries', compact('queriesGivenToTA'));
                
    }
}
