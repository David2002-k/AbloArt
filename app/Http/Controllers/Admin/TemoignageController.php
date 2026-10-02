<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Temoignage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TemoignageController extends Controller
{
    public function index(): View
    {
        $temoignages = Temoignage::query()->latest()->get();

        return view('admin.temoignages.index', compact('temoignages'));
    }

    public function update(Request $request, Temoignage $temoignage): RedirectResponse
    {
        $validated = $request->validate([
            'publie' => ['required', 'boolean'],
        ]);

        $temoignage->update($validated);

        return redirect()
            ->route('admin.temoignages.index')
            ->with('success', $request->boolean('publie')
                ? 'Le témoignage est maintenant publié.'
                : 'Le témoignage a été retiré de la publication.');
    }
}
