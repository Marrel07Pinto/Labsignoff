<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Query;
use App\Models\Seat;

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
            'q_description' => 'required|string',
        ]);
        
        $user_id = auth()->user()->id;
        $seat = Seat::where('users_id', $user_id)->first();
        $seat_number = $seat->seat_num;

        
        $qimage = '';
        
        if($request->hasFile('q_img'))
        {
            $img=$request->file('q_img');
            $qimage=time().'.'.$img->getClientOriginalExtension();
            $path=public_path('/images/query_images');
            $img->move($path,$qimage);

        }
           
            $query = new Query();
            $query->users_id = $user_id;
            $query->q_seat = $seat_number;
            $query->q_clink =$request->input('q_clink');
            $query->q_img = $qimage;
            $query->q_description=$request->input('q_description');
            $query->save();
            return back()->with('success', 'Query has been raised successfully!');
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
