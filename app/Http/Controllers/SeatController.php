<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Seat;
use App\Models\Profile;
use App\Models\Attendance;
use App\Models\Lab;
use Carbon\Carbon;



class SeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function homeindex()
    {
        return view('home');
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
        $labnumber = auth()->user()->lab;
        $user_id = Auth::id();
        $seat_number = $request->input('seat_number');

        // Fetch the existing seat for the user
        $existing_seat = Seat::where('users_id', $user_id)->first();
        $occup_seat = Seat::where('seat_num', $seat_number)->where('users_id', '!=', $user_id)->first();
        if ($occup_seat) {
            // If the selected seat is occupied by another user
            return back()->with('error', "Seat {$seat_number} has already been occupied.");
        }
        // Check if the user already has a seat
        if ($existing_seat && $existing_seat->seat_num !== $seat_number) {
            // Ask for confirmation to change the seat
            return back()->with('info', "Do you want to change your seat to {$seat_number}?")
                         ->with('seat_number', $seat_number);
        } 
        elseif ($existing_seat && $existing_seat->seat_num === $seat_number) 
        {
            // If user already has the same seat, proceed without asking any question
            return back()->with('error', 'You have selected your current seat again.');
        } 
        else 
        {
            // If user doesn't have a seat, assign the seat to the user
            $seat = new Seat();
            $seat->users_id = $user_id;
            $seat->seat_num = $seat_number;
            $seat->lab = $labnumber;
            $seat->save();   

            $timeseatbooked = Carbon::parse($seat->created_at);
            $labs = Lab::where('t_lab', $labnumber)->first();
            if($labs)
            {
                $ans = 'Absent';
                $Admintime = Carbon::parse($labs->date_time);
                $timeend = $Admintime->copy()->addMinutes(15);
                $extendedtimeend = $Admintime->copy()->addMinutes(30);
                if ($timeseatbooked->isSameDay($Admintime)) 
                {
                    if ($timeseatbooked->greaterThanOrEqualTo($Admintime) && $timeseatbooked->lessThanOrEqualTo($timeend)) 
                    {
                        $ans = 'Present';
                    } else if ($timeseatbooked->greaterThan($timeend) && $timeseatbooked->lessThanOrEqualTo($extendedtimeend )) {
                        $ans = 'Partial_Present';
                    }   
                
                }
                
                $attendance = Attendance::where('u_num', auth()->user()->u_num)
                            ->where('lab', $labnumber)
                            ->first();
                if ($attendance) 
                    {
                                
                        $attendance->atten = $ans;
                        $attendance->save();
                    }
                else
                    {
                        $attenstore = new Attendance();
                        $attenstore->name = auth()->user()->name;
                        $attenstore->u_num = auth()->user()->u_num;
                        $attenstore->lab = $labnumber;
                        $attenstore->atten = $ans;
                        $attenstore->save();
                    }
            }
            
           
        $userprofile = Profile::where('users_id', $user_id)->first();

            if ($userprofile) {
                $userprofile->seat_num = $seat_number;
                $userprofile->lab = $labnumber;
                $userprofile->save();
            } else {
                $userprofile = new Profile();
                $userprofile->users_id = $user_id;
                $userprofile->seat_num = $seat_number;
                $userprofile->lab = $labnumber;
                $userprofile->save();
            }
                        
                return redirect()->route('seat')->with('success', 'Seat selected successfully!');
        }
    }
    
    public function showSeatSelection()
    {
        $user_id = auth()->user()->id;
        $seatsoccupied = seat::all();
        return view('seat',compact('seatsoccupied')); 
    }
    public function show()
    {
        //
        $user_id = auth()->user()->id;
        $seatswithnav = seat::all();
        return view('seatwithnav',compact('seatswithnav')); 
    }
    /**
     * Display the specified resource.
     */

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
    public function adminseatshow()
    {
        $user = Auth::user();
        $TA = strpos($user->role, 'TA') === 0;
        return view('adminseatview', [
            'seatview' => Seat::all(),
            'TA' => $TA
        ]);
    }


}
