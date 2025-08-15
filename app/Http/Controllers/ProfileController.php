<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        $user = Auth::user()->load('profile');
        $divisions = Division::with('districts')->get();
        $districts = District::with('thanas')->get();
        return view('profile.edit', compact('user', 'divisions', 'districts'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $request->id,
            'phone' => 'required|string|regex:/^(\+88)?01[3-9][0-9]{2}\-?[0-9]{6}$/|unique:users,phone,' . $request->id,
            'password' => 'nullable|min:8',
        ]);


        $user = User::findOrFail($request->id);

        if (!$request->password) {
            $password = $user->password;
        } else {
            $password = Hash::make($request->password);
        }

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $password,
            ]);
            return redirect()->back()->with('success', 'Personal Information updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function userProfileUpdate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|min:1',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'address' => 'required|string|max:255',
            'division' => 'required|integer|exists:divisions,id',
            'district' => 'required|integer|exists:districts,id',
            'thana' => 'required|integer|exists:thanas,id',
            'postal_code' => 'nullable|string|max:10',
            'designation' => 'nullable|string|max:255',
            'dob' => 'required|date',
            'work_office' => 'required|string',
            'employee_status' => 'required|string|max:255',
            'links' => 'nullable|string|max:255',
            'biography' => 'nullable|string',
        ]);

        try {
            $userProfile = Auth::user()->profile;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $fileExtension = $file->getClientOriginalExtension();
                $fileLocation = 'uploads/photos/';
                $fileName = time() . '.' . $fileExtension;

                // Delete Old File
                $filePath = public_path($userProfile->photo);
                if (file_exists($filePath)) {
                    File::delete($filePath);
                }

                $userProfile->update([
                    'user_id' => $request->user_id,
                    'photo' => $fileLocation . $fileName,
                    'address' => $request->address,
                    'division' => $request->division,
                    'district' => $request->district,
                    'thana' => $request->thana,
                    'postal_code' => $request->postal_code,
                    'designation' => $request->designation,
                    'dob' => $request->dob,
                    'work_office' => $request->work_office,
                    'employee_status' => $request->employee_status,
                    'links' => $request->links,
                    'biography' => $request->biography,
                ]);
                // Upload New File
                $file->move(public_path($fileLocation), $fileName);
            } else {
                $userProfile->update([
                    'user_id' => $request->user_id,
                    'address' => $request->address,
                    'division' => $request->division,
                    'district' => $request->district,
                    'thana' => $request->thana,
                    'postal_code' => $request->postal_code,
                    'designation' => $request->designation,
                    'dob' => $request->dob,
                    'work_office' => $request->work_office,
                    'employee_status' => $request->employee_status,
                    'links' => $request->links,
                    'biography' => $request->biography,
                ]);
            }
            return redirect()->back()->with('success', 'Profile updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        //
    }

    public function adminUserProfileEdit(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $divisions = Division::with('districts')->get();
            $districts = District::with('thanas')->get();
            return view('profile.partials.profile-edit', compact('user', 'divisions','districts'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function adminUserProfileUpdate(Request $request, $id)
    {
        $request->validate([
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
            'address' => ['required', 'string'],
            'division' => ['required', 'string'],
            'district' => ['required', 'string'],
            'thana' => ['required', 'string'],
            'postal_code' => ['nullable', 'string'],
            'designation' => ['required', 'string'],
            'dob' => ['required', 'date'],
            'work_office' => ['required', 'string'],
            'employee_status' => ['required', 'string'],
            'links' => ['nullable', 'string'],
            'biography' => ['nullable', 'string'],
        ]);

        try {
            $userProfile = UserProfile::findOrFail($id);

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $fileExtension = $file->getClientOriginalExtension();
                $fileLocation = 'uploads/photos/';
                $fileName = time() . '.' . $fileExtension;

                // Delete Old File
                $filePath = public_path($userProfile->photo);
                if (file_exists($filePath)) {
                    File::delete($filePath);
                }

                $userProfile->update([
                    'user_id' => $userProfile->user_id,
                    'photo' => $fileLocation . $fileName,
                    'address' => $request->address,
                    'division' => $request->division,
                    'district' => $request->district,
                    'thana' => $request->thana,
                    'postal_code' => $request->postal_code,
                    'designation' => $request->designation,
                    'dob' => $request->dob,
                    'work_office' => $request->work_office,
                    'employee_status' => $request->employee_status,
                    'links' => $request->links,
                    'biography' => $request->biography,
                ]);
                // Upload New File
                $file->move(public_path($fileLocation), $fileName);
            } else {
                $userProfile->update([
                    'user_id' => $userProfile->user_id,
                    'address' => $request->address,
                    'division' => $request->division,
                    'district' => $request->district,
                    'thana' => $request->thana,
                    'postal_code' => $request->postal_code,
                    'designation' => $request->designation,
                    'dob' => $request->dob,
                    'work_office' => $request->work_office,
                    'employee_status' => $request->employee_status,
                    'links' => $request->links,
                    'biography' => $request->biography,
                ]);
            }
            return redirect()->back()->with('success', $userProfile->user->name . "'s profile updated successfully");
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
