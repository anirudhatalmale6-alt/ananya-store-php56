<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        return view('profile.edit', array(
            'user' => $request->user(),
        ));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, array(
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ));

        $user->fill($request->only(array('name', 'email')));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $this->validate($request, array(
            'current_password' => 'required|string',
            'password'         => 'required|string|min:8|confirmed',
        ));

        // Laravel 5.4 has no "current_password" validation rule, so the
        // check is performed explicitly here.
        if (! Hash::check($request->input('current_password'), $user->password)) {
            throw ValidationException::withMessages(array(
                'current_password' => array('The provided password does not match your current password.'),
            ))->errorBag('updatePassword');
        }

        $user->password = $request->input('password');
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'password-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        $this->validate($request, array(
            'password' => 'required|string',
        ));

        if (! Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages(array(
                'password' => array('The provided password is incorrect.'),
            ))->errorBag('userDeletion');
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
