<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemandePortrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DemandePortraitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $statuses = ['en_attente', 'acceptee', 'refusee', 'terminee'];
        $status = $request->string('statut')->toString();

        $demandes = DemandePortrait::query()
            ->when(in_array($status, $statuses, true), fn ($query) => $query->where('statut', $status))
            ->latest()
            ->get();

        return view('admin.demandes.index', compact('demandes', 'status', 'statuses'));
    }

    public function updateStatut(Request $request, DemandePortrait $demande): RedirectResponse
    {
        $validated = $request->validate([
            'statut' => ['required', 'in:en_attente,acceptee,refusee,terminee'],
        ]);

        $demande->update($validated);

        return back()->with('success', 'Le statut de la demande a été mis à jour.');
    }

    public function downloadPhoto(DemandePortrait $demande): StreamedResponse
    {
        abort_unless(
            $demande->photo_reference && Storage::disk('public')->exists($demande->photo_reference),
            404,
        );

        $extension = pathinfo($demande->photo_reference, PATHINFO_EXTENSION);

        return Storage::disk('public')->download(
            $demande->photo_reference,
            'photo-demande-'.$demande->id.($extension ? '.'.$extension : ''),
        );
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
