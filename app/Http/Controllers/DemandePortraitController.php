<?php

namespace App\Http\Controllers;

use App\Models\DemandePortrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DemandePortraitController extends Controller
{
    public function create(): View
    {
        return view('demandes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'telephone' => ['nullable', 'string', 'max:30'],
            'description' => ['required', 'string', 'min:10', 'max:5000'],
            'photo_reference' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if ($request->hasFile('photo_reference')) {
            $validated['photo_reference'] = $request->file('photo_reference')
                ->store('demandes/references', 'public');
        }

        DemandePortrait::create($validated);

        return redirect()
            ->route('demandes.create')
            ->with('success', 'Votre demande a bien été envoyée. Nous vous contacterons rapidement.');
    }
}
