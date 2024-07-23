<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Profile;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('login');
    }
    public function show()
    {
        $user_id = auth()->user()->id;
        $profileuser = Profile::where('users_id', $user_id)->first();
        return view('usersprofile',compact('profileuser'));
    }
    public function profileuupdate(Request $request, string $id)
    {
        $request->validate([
            'p_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validate single image
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->user()->id],
            'name' => 'required|string|max:255',
        ], [
            'p_img.image' => 'The file must be an image.',
            'p_img.mimes' => 'Image should be of type jpeg, png, jpg.',
            'email.unique' => 'The email has already been taken.',
        ]);
    
        // Find the profile
        $profileuedit = Profile::findOrFail($id);
    
        // Handle image upload
        if ($request->hasFile('p_img')) {
            $existingImage = $profileuedit->p_img;
            if ($existingImage) {
                $imagePath = public_path('/images/profile_images/') . $existingImage;
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Delete existing image from server
                }
            }
    
            // Upload and store new image
            $img = $request->file('p_img');
            $newImageName = time() . '_' . $img->getClientOriginalName();
            $img->move(public_path('/images/profile_images'), $newImageName);
        } else {
            // If no new image is uploaded, retain the existing image name
            $newImageName = $profileuedit->p_img;
        }
    
        // Update the profile and user data
        $profileuedit->p_img = $newImageName;
        $profileuedit->save();
    
        $user = $profileuedit->user; // Assuming you have a 'user' relationship on Profile
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
    
        return back()->with('success', 'Profile has been updated successfully!');
    }
}
