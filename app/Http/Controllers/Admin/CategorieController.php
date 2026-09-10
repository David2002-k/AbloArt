<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Categorie::withCount('portraits')->orderBy('nom')->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:categories,nom'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        Categorie::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Catégorie ajoutée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie): View
    {
        return view('admin.categories.show', compact('categorie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categorie $categorie): View
    {
        return view('admin.categories.edit', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $categorie): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:categories,nom,'.$categorie->id],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $categorie->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Catégorie modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie): RedirectResponse
    {
        if ($categorie->portraits()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Cette catégorie ne peut pas être supprimée car elle contient des portraits.');
        }

        $categorie->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}
