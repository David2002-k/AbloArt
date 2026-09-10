<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Portrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortraitController extends Controller
{
    /**
     * Afficher la liste des portraits.
     */
    public function index()
    {
        $portraits = Portrait::with('categorie')
            ->latest()
            ->get();

        return view('admin.index', compact('portraits'));
    }

    /**
     * Afficher le formulaire d'ajout.
     */
    public function create()
    {
        $categories = Categorie::orderBy('nom')->get();

        return view('admin.create', compact('categories'));
    }

    /**
     * Enregistrer un nouveau portrait.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categorie_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'video' => ['nullable', 'file', 'mimes:mp4,mov,avi,webm', 'max:20480'],
            'date_realisation' => ['nullable', 'date'],
        ]);

        // Récupérer l'administrateur connecté
        $admin = $request->user()->admin;

        // Enregistrer l'image
        $imagePath = $request->file('image')
            ->store('portraits/images', 'public');

        // Enregistrer la vidéo si elle existe
        $videoPath = null;

        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')
                ->store('portraits/videos', 'public');
        }

        Portrait::create([
            'categorie_id' => $validated['categorie_id'],
            'admin_id' => $admin->id,
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'video' => $videoPath,
            'date_realisation' => $validated['date_realisation'] ?? null,
        ]);

        return redirect()
            ->route('admin.portraits.index')
            ->with('success', 'Portrait ajouté avec succès.');
    }

    /**
     * Afficher un portrait.
     */
    public function show(Portrait $portrait)
    {
        return view('admin.show', compact('portrait'));
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(Portrait $portrait)
    {
        $categories = Categorie::orderBy('nom')->get();

        return view('admin.edit', compact(
            'portrait',
            'categories'
        ));
    }

    /**
     * Modifier un portrait.
     */
    public function update(Request $request, Portrait $portrait)
    {
        $validated = $request->validate([
            'categorie_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'video' => ['nullable', 'file', 'mimes:mp4,mov,avi,webm', 'max:20480'],
            'date_realisation' => ['nullable', 'date'],
        ]);

        $portrait->categorie_id = $validated['categorie_id'];
        $portrait->description = $validated['description'] ?? null;
        $portrait->date_realisation = $validated['date_realisation'] ?? null;

        // Nouvelle image
        if ($request->hasFile('image')) {

            if ($portrait->image) {
                Storage::disk('public')->delete($portrait->image);
            }

            $portrait->image = $request->file('image')
                ->store('portraits/images', 'public');
        }

        // Nouvelle vidéo
        if ($request->hasFile('video')) {

            if ($portrait->video) {
                Storage::disk('public')->delete($portrait->video);
            }

            $portrait->video = $request->file('video')
                ->store('portraits/videos', 'public');
        }

        $portrait->save();

        return redirect()
            ->route('admin.portraits.index')
            ->with('success', 'Portrait modifié avec succès.');
    }

    /**
     * Supprimer un portrait.
     */
    public function destroy(Portrait $portrait)
    {
        // Supprimer l'image
        if ($portrait->image) {
            Storage::disk('public')->delete($portrait->image);
        }

        // Supprimer la vidéo
        if ($portrait->video) {
            Storage::disk('public')->delete($portrait->video);
        }

        $portrait->delete();

        return redirect()
            ->route('admin.portraits.index')
            ->with('success', 'Portrait supprimé avec succès.');
    }
}
