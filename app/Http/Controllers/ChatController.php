<?php

namespace App\Http\Controllers;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
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
        $validatedData = $request->validate([
            'c_messages' => 'required|string|max:10000', // Example: max length of 10,000 characters
        ]);
        $user_id = auth()->user()->id;
        $chat = new Chat();
        $chat->users_id = $user_id;
        $chat->c_messages = $request->input('c_messages');
        $chat->save();
        return back()->with('success', 'Message sent successfully');
    }

    /**
     * Display the specified resource.
     */
    public function showlayout()
    {
        $user = Auth::user();
        $TA = strpos($user->role, 'TA') === 0;
        return view('chat', [
            'chatmessages' => Chat::all(),
            'TA' => $TA
        ]);
        
    }
    public function adminshow()
    {
        $chatmessages = Chat::all();
        return view('adminchat',compact('chatmessages'));
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
