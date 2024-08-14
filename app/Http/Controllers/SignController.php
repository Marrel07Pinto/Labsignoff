<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;
use App\Models\Sign;
use App\Models\User;
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
    
    public function signsolution(Request $request)
    {
        $sign = Sign::find($request->input('sign_id'));
        if ($sign) {
            $sign->s_resolved_by = auth()->user()->name;
            $sign->s_solution = $request->input('solution'); 
            $sign->save();
        }
        
        return redirect()->back()->with('success', 'Query resolved successfully.');
    
    }

    public function showsign()
{
    $signdata = User::select('id', 'name', 'email', 'password', 'u_num')
        ->where('role', 'TA')
        ->orderBy('id', 'asc')
        ->get();

    // Fetch all queries
    $sdata = Sign::all();

    // Prepare the data to be passed to the view
    $signsGivenToTA = [];
    $tasign = [];
    $pendingsign = [];

    // Get the list of TA names for quick lookup
    $taNames = $signdata->pluck('name')->toArray();

    // Assign queries based on `resolved_by`
    foreach ($signdata as $ta) {
        $tasign[$ta->id] = collect();
    }

    foreach ($sdata as $sign) {
        if (!empty($sign->s_resolved_by)) {
            if (in_array($sign->s_resolved_by, $taNames)) {
                $ta = $signdata->firstWhere('name', $sign->s_resolved_by);
                if ($ta) {
                    $tasign[$ta->id][] = $sign;
                    continue;
                }
            } else {
                continue;
            }
        }
        $pendingsign[] = $sign;
    }

    // Filter out queries where s_state is not null
    $unresolvedsign = array_filter($pendingsign, function ($sign) {
        return $sign->s_state === null;
    });

    // Distribute remaining queries
    $taIds = $signdata->pluck('id')->toArray();
    $taCount = count($taIds);

    if ($taCount > 0 && !empty($unresolvedsign)) {
        $taIndex = 0;
        foreach ($unresolvedsign as $sign) {
            $taId = $taIds[$taIndex % $taCount];
            $tasign[$taId][] = $sign;
            $taIndex++;
        }
    }

    // Prepare data for view
    foreach ($signdata as $index => $ta) {
        $signsGivenToTA[$index]['ta'] = $ta;
        $signsGivenToTA[$index]['signs'] = $tasign[$ta->id];
    }

    return view('adminsign', compact('signsGivenToTA'));
}
public function tasign()
{
    $signdata = User::select('id', 'name', 'email', 'password', 'u_num')
        ->where('role', 'TA')
        ->orderBy('id', 'asc')
        ->get();

    // Fetch all queries
    $sdata = Sign::all();

    // Prepare the data to be passed to the view
    $signsGivenToTA = [];
    $tasign = [];
    $pendingsign = [];

    // Get the list of TA names for quick lookup
    $taNames = $signdata->pluck('name')->toArray();

    // Assign queries based on `resolved_by`
    foreach ($signdata as $ta) {
        $tasign[$ta->id] = collect();
    }

    foreach ($sdata as $sign) {
        if (!empty($sign->s_resolved_by)) {
            if (in_array($sign->s_resolved_by, $taNames)) {
                $ta = $signdata->firstWhere('name', $sign->s_resolved_by);
                if ($ta) {
                    $tasign[$ta->id][] = $sign;
                    continue;
                }
            } else {
                continue;
            }
        }
        $pendingsign[] = $sign;
    }

    // Filter out queries where s_state is not null
    $unresolvedsign = array_filter($pendingsign, function ($sign) {
        return $sign->s_state === null;
    });

    // Distribute remaining queries
    $taIds = $signdata->pluck('id')->toArray();
    $taCount = count($taIds);

    if ($taCount > 0 && !empty($unresolvedsign)) {
        $taIndex = 0;
        foreach ($unresolvedsign as $sign) {
            $taId = $taIds[$taIndex % $taCount];
            $tasign[$taId][] = $sign;
            $taIndex++;
        }
    }

    // Prepare data for view
    foreach ($signdata as $index => $ta) {
        $signsGivenToTA[$index]['ta'] = $ta;
        $signsGivenToTA[$index]['signs'] = $tasign[$ta->id];
    }

    return view('tasign', compact('signsGivenToTA'));
}
public function refreshsigns() 
{
    // Fetch all TAs
    $taData = User::select('id', 'name', 'email', 'password', 'u_num')
        ->where('role', 'like', 'TA')
        ->orderBy('id', 'asc')
        ->get();

    // Fetch all sign-off requests
    $signData = Sign::all();

    $signsGivenToTA = [];
    $taSigns = [];
    $pendingSigns = [];
    $taNames = $taData->pluck('name')->toArray();

    // Initialize array for signs per TA
    foreach ($taData as $ta) 
    {
        $taSigns[$ta->id] = collect();
    }

    // Assign signs based on `resolved_by`
    foreach ($signData as $sign) 
    {
        if (!empty($sign->s_resolved_by)) 
        {
            if (in_array($sign->s_resolved_by, $taNames)) 
            {
                $ta = $taData->firstWhere('name', $sign->s_resolved_by);
                if ($ta) 
                {
                    $taSigns[$ta->id][] = $sign;
                    continue;
                }
            } 
            else 
            {
                continue;
            }
        }
        $pendingSigns[] = $sign;
    }

    // Filter out signs where `s_state` is null
    $unresolvedSigns = array_filter($pendingSigns, function($sign) 
    {
        return $sign->s_state === null;
    });

    // Distribute remaining signs
    $taIds = $taData->pluck('id')->toArray();
    $taCount = count($taIds);

    if ($taCount > 0 && !empty($unresolvedSigns)) 
    {
        $taIndex = 0;
        foreach ($unresolvedSigns as $sign) 
        {
            $taId = $taIds[$taIndex % $taCount];
            $taSigns[$taId][] = $sign;
            $taIndex++;
        }
    }

    // Prepare data for view
    foreach ($taData as $index => $ta) 
    {
        $signsGivenToTA[$index]['ta'] = $ta;
        $signsGivenToTA[$index]['signs'] = $taSigns[$ta->id];
    }

    return view('partials.refreshsign', compact('signsGivenToTA'));
}

public function SignStatus(Request $request)
    {
        $sign = Sign::find($request->input('id'));
        if ($sign) 
        {
            $sign->s_state = $request->input('status');
            $sign->save();
        }
        return response()->json(['success' => true]);
    }
}
