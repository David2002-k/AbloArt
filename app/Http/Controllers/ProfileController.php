<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'admin' => $request->user()->admin,
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();
        $passwordWasUpdated = filled($validated['password'] ?? null);

        // Mise à jour des informations de la table users
        $user->fill(collect($validated)->only(['name', 'email'])->all());
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        if ($passwordWasUpdated) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();
        // Récupération du profil administrateur
        $admin = $user->admin;
        if ($admin) {
            $admin->biographie = $request->input('biographie');
            $admin->telephone = $request->input('telephone');
            $admin->adresse = $request->input('adresse');

            if ($request->hasFile('photo')) {
                if ($admin->photo) {
                    Storage::disk('public')->delete($admin->photo);
                }
                $admin->photo = $request->file('photo')
                    ->store('admins/photos', 'public');
            }

            if ($request->hasFile('cv')) {
                if ($admin->cv) {
                    Storage::disk('public')->delete($admin->cv);
                }
                $admin->cv = $request->file('cv')
                    ->store('admins/cv', 'public');
            }
            $admin->save();
        }

        return Redirect::route('profile.edit')
            ->with('status', $passwordWasUpdated ? 'password-updated' : 'profile-updated');
    }

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

        return Redirect::to('/');
    }
}
