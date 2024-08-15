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
        
                // Check if the user's role is 'ADMIN'
                if ($user->role === 'ADMIN') {
                    return redirect()->route('adminseatview');
                }

            // Regular authentication for other users
            $request->authenticate();

            $request->session()->regenerate();
            $user = auth()->user();
        
            if (str_starts_with($user->role, 'TA')) {
                return redirect()->route('taskupload');
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
            if ($user->role === 'student') {
                $userId = $user->id;
                DB::table('seats')->where('users_id', $userId)->delete();
            }
            Auth::guard('web')->logout();
            $request->session()->invalidate();

            $request->session()->regenerateToken();
        }
        return redirect()->route('login');
    }
}
