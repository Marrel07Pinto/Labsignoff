<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Attendance;
use App\Models\Lab;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) 
        {
                $user = auth()->user();
                $lab = $request->input('lab');
                $user->lab = $lab;
                $user->save();
        
                // Check if the user's role is 'ADMIN'
                if ($user->role === 'ADMIN') {
                    return redirect()->route('adminseatview');
                }

            // Regular authentication for other users
            $request->authenticate();

            $request->session()->regenerate();
            $user = auth()->user();
        
            if (str_starts_with($user->role, 'TA')) {
                return redirect()->route('task');
            }

             return redirect()->route('seat');
        }
        return redirect()->back()->withErrors(['email' => 'credentials do not match our records.']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {

        $user = Auth::guard('web')->user();
        if ($user) {
            if ($user->role === 'student') 
            {
                $userId = $user->id;
                DB::table('seats')->where('users_id', $userId)->delete();

                $logouttime = now(); 
        $user->last_logout_at = $logouttime;
        $user->save();
        $labnumber = $user->lab; 

        // Retrieve lab details
        $labs = Lab::where('t_lab', $labnumber)->first();
        if ($labs) 
        {
            $Admintime = Carbon::parse($labs->date_time);
            $timeend = $Admintime->copy()->addMinutes(15);
            $extendedtimeend = $Admintime->copy()->addMinutes(30);

            // Retrieve the existing attendance record
            $attendance = Attendance::where('u_num', $user->u_num)
                ->where('lab', $labnumber)
                ->first();

            // Update attendance status to 'Absent' if logout time falls within the range
            if ($logouttime->greaterThanOrEqualTo($Admintime) && $logouttime->lessThanOrEqualTo($extendedtimeend)) 
            {
                if ($attendance) 
                {
                    $attendance->atten = 'Absent';
                    $attendance->save();
                }
            }
        }
            }
            Auth::guard('web')->logout();
            $request->session()->invalidate();

            $request->session()->regenerateToken();
        }
        return redirect()->route('login');
    }
    
}
