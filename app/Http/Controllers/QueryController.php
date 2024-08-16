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
        $request->validate([
            
            's_img' => 'nullable|array',
            's_img.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            's_img.*.mimes' => 'Each image should be of type jpeg, png, jpg.',
            's_img.*.max' => 'Each image should not be larger than 2MB.',

        ]);

        $validatedData = $request->validate([
            'q_query' => 'required|string|max:10000', // Example: max length of 10,000 characters
        ]);
        $labnumber = auth()->user()->lab;
        $user_id = auth()->user()->id;
        $seat = Seat::where('users_id', $user_id)->first();
        $seat_number = $seat->seat_num;
        $imageNames = [];

        
        if ($request->has('q_img')) {
            foreach ($request->q_img as $img) {
                $imageName = time().'_'.$img->getClientOriginalName();
                $img->move(public_path('/images/query_images'), $imageName);
                $imageNames[] = $imageName; // Store each image name in the array
            }
        }

        $query = new Query();
        $query->users_id = $user_id;
        $query->q_seat = $seat_number;
        $query->q_img = json_encode($imageNames);
        $query->q_query= $validatedData['q_query'];
        $query->lab =   $labnumber;
        $query->save();

        return back()->with('success', 'Query has been raised successfully!');
    }
    public function query_solution(Request $request)
    {
        $validatedData = $request->validate([
            'solution' => 'nullable|required|string|max:10000', // Example: max length of 10,000 characters
        ]);
        $query = Query::find($request->input('query_id'));
        if ($query) {
            $query->resolved_by = auth()->user()->name;
            $query->solution = $validatedData['solution'];
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
        $querydata = User::select('id', 'name', 'email', 'password', 'u_num')
            ->where('role', 'like', 'TA')
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
    
        // Filter out queries where q_state is not null
        $unresolvedQueries = array_filter($pendingQueries, function($query) {
            return $query->q_state === null;
        });
    
        // Distribute remaining queries
        $taIds = $querydata->pluck('id')->toArray();
        $taCount = count($taIds);
    
        if ($taCount > 0 && !empty($unresolvedQueries)) {
            $taIndex = 0;
            foreach ($unresolvedQueries as $query) {
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
            ->where('role', 'like', 'TA')
            ->orderBy('id', 'asc')
            ->get();
        $qdata = Query::all();
        $queriesGivenToTA = [];
        $taQueries = [];
        $pendingQueries = [];
        $tanames = $querydata->pluck('name')->toArray();
        foreach ($querydata as $ta) {
            $taQueries[$ta->id] = collect();
        }
    
        foreach ($qdata as $query) {
            if (!empty($query->resolved_by)) {
                if (in_array($query->resolved_by, $tanames)) {
                    $ta = $querydata->firstWhere('name', $query->resolved_by);
                    if ($ta) {
                        $taQueries[$ta->id][] = $query;
                        continue; 
                    }
                } else {
                   
                    continue;
                }
            }
            $pendingQueries[] = $query;
        }
    
        
        $unresolvedQueries = array_filter($pendingQueries, function($query) {
            return $query->q_state === null;
        });
    
        
        $taIds = $querydata->pluck('id')->toArray();
        $taCount = count($taIds);
    
        if ($taCount > 0 && !empty($unresolvedQueries)) {
            $taIndex = 0;
            foreach ($unresolvedQueries as $query) {
                $taId = $taIds[$taIndex % $taCount];
                $taQueries[$taId][] = $query;
                $taIndex++;
            }
        }
    
        
        foreach ($querydata as $index => $ta) {
            $queriesGivenToTA[$index]['ta'] = $ta;
            $queriesGivenToTA[$index]['queries'] = $taQueries[$ta->id];
        }
    
        return view('taqueries', compact('queriesGivenToTA'));
    }
    
    public function refreshqueries() 
    {
            $querydata = User::select('id', 'name', 'email', 'password', 'u_num')
                ->where('role', 'like', 'TA')
                ->orderBy('id', 'asc')
                ->get();
            $qdata = Query::all();
            $queriesGivenToTA = [];
            $taQueries = [];
            $pendingQueries = [];
            $tanames = $querydata->pluck('name')->toArray();
            foreach ($querydata as $ta) 
            {
                $taQueries[$ta->id] = collect();
            }
            foreach ($qdata as $query) 
            {
                if (!empty($query->resolved_by)) 
                {
                    if (in_array($query->resolved_by, $tanames)) 
                    {
                        $ta = $querydata->firstWhere('name', $query->resolved_by);
                        if ($ta) 
                        {
                            $taQueries[$ta->id][] = $query;
                            continue; 
                        }
                    }    
                    else 
                    {
                            
                            continue;
                    }
                }
                $pendingQueries[] = $query;
            }
            $unresolvedQueries = array_filter($pendingQueries, function($query) 
            {
                return $query->q_state === null;
            });
            $taIds = $querydata->pluck('id')->toArray();
            $taCount = count($taIds);

            if ($taCount > 0 && !empty($unresolvedQueries)) 
            {
                $taIndex = 0;
                foreach ($unresolvedQueries as $query) 
                {
                    $taId = $taIds[$taIndex % $taCount];
                    $taQueries[$taId][] = $query;
                    $taIndex++;
                }
            }
            foreach ($querydata as $index => $ta) 
            {
            $queriesGivenToTA[$index]['ta'] = $ta;
            $queriesGivenToTA[$index]['queries'] = $taQueries[$ta->id];
            }
        return view('partials.refreshqueries', compact('queriesGivenToTA'));
    }

    public function QueryStatus(Request $request)
    {
        $query = Query::find($request->input('id'));
        if ($query) 
        {
            $query->q_state = $request->input('status');
            $query->save();
        }
        return response()->json(['success' => true]);
    }
}
