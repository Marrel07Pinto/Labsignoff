<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rules;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class TaregistrationController extends Controller
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'u_num' => ['required', 'regex:/^[0-9a-zA-Z]+$/','unique:users,u_num'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],[
            'u_num.unique' => 'This university number is already taken.', 
        ]);
        $u_number = $request->input('u_num');
        $u_num = 'TA-' . $u_number;

        if (User::where('u_num', $u_num)->exists()) {
            return back()->withErrors(['u_num' => 'The university number is already taken.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'u_num' => $u_num,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

       // Auth::login($user);

        return redirect()->route('ta_registration')->with('success', 'Registration successful !!!');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        
        $datata = User::select('id','name', 'email', 'password','u_num')->where('u_num', 'like', 'TA-%')->orderBy('id', 'asc')->get();
        return view('ta_registration',compact('datata'));
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
        
        $tadata = User::find($id);
        $tadata->delete();
        return back()->with('success', 'Credentials has been deleted successfully!');
    }
}
