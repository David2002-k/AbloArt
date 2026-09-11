<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\DemandePortrait;
use App\Models\Message;
use App\Models\Portrait;
use App\Models\Temoignage;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $portraitCategories = Categorie::query()
            ->withCount('portraits')
            ->orderByDesc('portraits_count')
            ->take(6)
            ->get()
            ->map(fn (Categorie $categorie): array => [
                'name' => $categorie->nom,
                'count' => $categorie->portraits_count,
            ]);

        $requestStatuses = collect([
            'en_attente' => 'En attente',
            'acceptee' => 'Acceptées',
            'refusee' => 'Refusées',
            'terminee' => 'Terminées',
        ])->mapWithKeys(fn (string $label, string $status): array => [
            $label => DemandePortrait::query()->where('statut', $status)->count(),
        ]);

        $messageStatuses = collect([
            'non_lu' => 'Non lus',
            'lu' => 'Lus',
            'traite' => 'Traités',
        ])->mapWithKeys(fn (string $label, string $status): array => [
            $label => Message::query()->where('statut', $status)->count(),
        ]);

        return view('admin.dashboard', [
            'messages' => Message::query()->latest()->take(10)->get(),
            'unreadMessagesCount' => Message::query()->where('statut', 'non_lu')->count(),
            'portraitCount' => Portrait::count(),
            'requestCount' => DemandePortrait::count(),
            'testimonialCount' => Temoignage::count(),
            'portraitCategories' => $portraitCategories,
            'requestStatuses' => $requestStatuses,
            'messageStatuses' => $messageStatuses,
        ]);
    }
}
