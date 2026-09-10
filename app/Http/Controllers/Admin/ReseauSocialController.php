<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReseauSocial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReseauSocialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $reseaux = ReseauSocial::orderBy('nom')->get();

        return view('admin.reseaux.index', compact('reseaux'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.reseaux.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $reseau = $request->validate([
            'nom' => ['required', 'string', 'max:50'],
            'url' => ['required', 'url', 'max:500'],
            'icone' => ['nullable', 'string', 'max:100'],
            'actif' => ['boolean'],
        ]);

        $reseau['actif'] = $request->boolean('actif');
        ReseauSocial::create($reseau);

        return redirect()->route('admin.reseaux.index')->with('success', 'Réseau social ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ReseauSocial $reseau): View
    {
        return view('admin.reseaux.show', compact('reseau'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReseauSocial $reseau): View
    {
        return view('admin.reseaux.edit', compact('reseau'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReseauSocial $reseau): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:50'],
            'url' => ['required', 'url', 'max:500'],
            'icone' => ['nullable', 'string', 'max:100'],
            'actif' => ['boolean'],
        ]);

        $validated['actif'] = $request->boolean('actif');
        $reseau->update($validated);

        return redirect()->route('admin.reseaux.index')->with('success', 'Réseau social modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReseauSocial $reseau): RedirectResponse
    {
        $reseau->delete();

        return redirect()->route('admin.reseaux.index')->with('success', 'Réseau social supprimé avec succès.');
    }
}
