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
            
            's_img' => 'nullable|array',
            's_img.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            's_img.*.mimes' => 'Each image should be of type jpeg, png, jpg.',
            's_img.*.max' => 'Each image should not be larger than 2MB.',

        ]);
        $validatedData = $request->validate([
            's_description' => 'required|string|max:10000', // Example: max length of 10,000 characters
        ]);

        
        $user_id = auth()->user()->id;
        $seat = Seat::where('users_id', $user_id)->first();
        $seat_number = $seat->seat_num;
        

        $imageNames = [];

        
        if ($request->has('s_img')) {
            foreach ($request->s_img as $img) {
                $imageName = time().'_'.$img->getClientOriginalName();
                $img->move(public_path('/images/signoff_images'), $imageName);
                $imageNames[] = $imageName; // Store each image name in the array
            }
        }
           
            $sign = new Sign();
            $sign->users_id = $user_id;
            $sign->s_seat = $seat_number;
            $sign->s_clink =$request->input('s_clink');
            $sign->s_img = json_encode($imageNames);
            $sign->s_description= $validatedData['s_description'];
            $sign->save();
            return back()->with('success', 'Sign-off requested');
    }


    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user_id = auth()->user()->id;
        $signoff = Sign::where('users_id', $user_id)->get();
        return view('sign',compact('signoff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $signedit = Sign::find($id);
        return view('signedit',compact('signedit'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            
            's_img' => 'nullable|array',
            's_img.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            's_img.image' => 'The file must be an image.',
            's_img.mimes' => 'Image should be of type jpeg, png, jpg.',
            

        ]);
        $validatedData = $request->validate([
            's_description' => 'required|string|max:10000', // Example: max length of 10,000 characters
        ]);
        $signedit = Sign::find($id);

        $newImageNames = [];
        if ($request->hasFile('s_img')) {
            // Delete existing images if any
            $existingImages = json_decode($signedit->s_img, true) ?? [];
            foreach ($existingImages as $existingImage) {
                $imagePath = public_path('/images/signoff_images/') . $existingImage;
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Delete existing image from server
                }
                
            }
            // Upload and store new images
            foreach ($request->file('s_img') as $img) {
                $imageName = time() . '_' . $img->getClientOriginalName();
                $img->move(public_path('/images/signoff_images'), $imageName);
                $newImageNames[] = $imageName;
            }
        }
        else 
        {
        $newImageNames = json_decode($signedit->s_img, true) ?? [];
        }
        

        
        $signedit->s_clink =$request->input('s_clink');
        $signedit->s_img = json_encode($newImageNames);
        $signedit->s_description= $validatedData['s_description'];
        $signedit->update();
        return back()->with('success', 'Sign-off requested has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $signoff = Sign::find($id);
        $signoff->delete();
        return back()->with('success', 'Request for lab sign-off has been deleted successfully!');
    }
    public function signview($sign)
    {
        $signview = Sign::findOrFail($sign);
        return view('signview', compact('signview'));
    }
}
