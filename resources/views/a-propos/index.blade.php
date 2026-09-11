<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Découvrez l'histoire et la vision d'AbloArt.">
        <title>À propos de nous | AbloArt</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="home-page">
        <nav class="navbar navbar-expand-lg home-navbar sticky-top">
            <div class="container d-flex justify-content-between align-items-center">
                <a class="navbar-brand home-brand" href="{{ route('welcome') }}">Ablo<span>Art</span><i></i></a>
                <a class="btn btn-outline-dark btn-sm" href="{{ route('welcome') }}">Retour à l'accueil</a>
            </div>
        </nav>

        <main class="container py-5">
            <section class="row align-items-center g-5 py-lg-5">
                <div class="col-lg-7">
                    <p class="eyebrow mb-3">À propos de nous</p>
                    <h1 class="hero-title mb-4">L'art de raconter<br><em>ce qui compte.</em></h1>
                    <p class="lead text-secondary">AbloArt crée des portraits personnalisés avec sensibilité et précision. Chaque création transforme un visage, un souvenir ou une émotion en une pièce unique à conserver.</p>
                </div>
                <div class="col-lg-5 text-center">
                    @if ($admin?->photo)
                        <img src="{{ asset('storage/'.$admin->photo) }}" alt="Photo de {{ $admin->user?->name ?? 'AbloArt' }}" class="img-fluid rounded-circle shadow-sm" style="width: 260px; height: 260px; object-fit: cover;">
                    @else
                        <div class="mx-auto d-flex align-items-center justify-content-center rounded-circle bg-teal-700 text-white shadow-sm" style="width: 260px; height: 260px; font-size: 7rem;">A</div>
                    @endif
                </div>
            </section>

            <section class="activity-panel mt-5 p-4 p-lg-5">
                <p class="eyebrow mb-3">Notre démarche</p>
                <h2 class="h2 mb-3">Des créations pensées pour durer.</h2>
                <p class="text-secondary mb-0">{{ $admin?->biographie ?? 'Notre atelier prend le temps d’écouter chaque histoire pour créer des portraits sincères, soignés et profondément personnels.' }}</p>
            </section>

            <div class="d-flex flex-wrap gap-3 mt-5">
                <a href="{{ route('galerie.index') }}" class="btn btn-dark">Découvrir la galerie <span aria-hidden="true">↗</span></a>
                <a href="{{ route('demandes.create') }}" class="btn btn-coral">Demander un portrait <span aria-hidden="true">↗</span></a>
            </div>
        </main>
    </body>
</html>
