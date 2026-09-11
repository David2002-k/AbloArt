<?php

namespace App\Http\Controllers;

use App\Models\Temoignage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TemoignageController extends Controller
{
    public function index(): View
    {
        $temoignages = Temoignage::query()
            ->where('publie', true)
            ->latest()
            ->get();

        return view('temoignages.index', compact('temoignages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        Temoignage::create([
            ...$validated,
            'publie' => false,
        ]);

        return redirect()
            ->route('temoignages.index')
            ->with('success', 'Merci pour votre témoignage. Il sera publié après validation.');
    }
}
