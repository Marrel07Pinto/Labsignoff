<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;
use App\Models\Sign;
class SignController extends Controller
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
            's_description' => 'required|string',
            's_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            's_img.image' => 'The file must be an image.',
            's_img.mimes' => 'Image should be of type jpeg, png, jpg.',

        ]);

        
        $user_id = auth()->user()->id;
        $seat = Seat::where('users_id', $user_id)->first();
        $seat_number = $seat->seat_num;

        
        $simage = '';
        
        if($request->hasFile('s_img'))
        {
            $img=$request->file('s_img');
            $simage=time().'.'.$img->getClientOriginalExtension();
            $path=public_path('/images/signoff_images');
            $img->move($path,$simage);

        }
           
            $sign = new Sign();
            $sign->users_id = $user_id;
            $sign->s_seat = $seat_number;
            $sign->s_clink =$request->input('s_clink');
            $sign->s_img = $simage;
            $sign->s_description=$request->input('s_description');
            $sign->save();
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
