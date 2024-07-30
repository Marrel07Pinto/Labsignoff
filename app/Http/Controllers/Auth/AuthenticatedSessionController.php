<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        if ($request->email === 'admin@gmail.com' && $request->password === 'Admin@123') {
            // Manually log in the admin user if credentials match
            auth()->loginUsingId(1); // Assuming the admin has an ID of 1
            return redirect()->route('ta_registration');
        }

        // Regular authentication for other users
        $request->authenticate();

        $request->session()->regenerate();
        $user = auth()->user();
    
        if (str_starts_with($user->u_num, 'TA-')) {
            return redirect()->route('taskupload'); 
        }

        return redirect()->route('seat');
    
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
