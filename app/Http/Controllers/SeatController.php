<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Seat;


class SeatController extends Controller
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
        $user_id = Auth::id();
        $seat_number = $request->input('seat_number');

        // Fetch the existing seat for the user
        $existing_seat = Seat::where('users_id', $user_id)->first();
        // Check if the user already has a seat
        if ($existing_seat && $existing_seat->seat_num !== $seat_number) {
            // Ask for confirmation to change the seat
            return back()->with('info', "Do you want to change your seat to {$seat_number}?")
                         ->with('seat_number', $seat_number);
        } elseif ($existing_seat && $existing_seat->seat_num === $seat_number) {
            // If user already has the same seat, proceed without asking any question
            return back()->with('success', 'You have selected your current seat again.');
        } else {
            // If user doesn't have a seat, assign the seat to the user
            $seat = new Seat();
            $seat->users_id = $user_id;
            $seat->seat_num = $seat_number;
            $seat->save();
            
            return back()->with('success', 'Seat selected successfully!');
        }
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
    public function update(Request $request,$id)
    {
        $seat_number = $request->input('seat_number');
        $seat = Seat::where('users_id', $id)->first();
        if ($seat) 
        {
            // Update the seat number
            $seat->users_id = $id;
            $seat->seat_num = $seat_number;
            $seat->save();

            // Redirect back with a success message
            return back()->with('success', "Seat changed to $seat_number successfully!");
        } 
        else 
        {
            // Handle case where no seat is found
            return back()->with('error', 'No seat found to update.');
        
        }
       
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
