<?php

namespace App\Http\Controllers;

use App\Models\Portrait;
use Illuminate\View\View;

class GalerieController extends Controller
{
    public function index(): View
    {
        $portraits = Portrait::with('categorie')
            ->latest('date_realisation')
            ->latest()
            ->get();

        return view('galerie.index', compact('portraits'));
    }
}
