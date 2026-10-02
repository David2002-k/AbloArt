<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Galerie | AbloArt</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="home-page gallery-page">
        <nav class="navbar home-navbar sticky-top">
            <div class="container d-flex justify-content-between">
                <a class="navbar-brand home-brand" href="{{ route('welcome') }}">Ablo<span>Art</span><i></i></a> 
                <a class="btn btn-outline-dark btn-sm" href="{{ route('welcome') }}">Retour à l'accueil</a>
            </div>
        </nav>
        <main class="container gallery-main py-5">
            <div class="gallery-heading mb-5">
                <p class="eyebrow">Les créations AbloArt</p>
                <h1 class="hero-title">Une galerie de<br><em>portraits uniques.</em></h1>
                <p class="gallery-intro mb-0">Un aperçu des portraits et des instants créés à l’atelier.</p>
            </div>
            @if ($portraits->isNotEmpty())
                <div class="row g-4">
                    @foreach ($portraits as $portrait)
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <article class="gallery-artwork h-100 overflow-hidden">
                                @if ($portrait->image)
                                    <div class="gallery-media">
                                        <img src="{{ asset('storage/'.$portrait->image) }}" alt="Portrait {{ $portrait->categorie?->nom ?? 'AbloArt' }}" loading="lazy">
                                    </div>
                                @endif
                                @if ($portrait->video)
                                    <div class="gallery-media gallery-video">
                                        <video controls preload="metadata" @if ($portrait->image) poster="{{ asset('storage/'.$portrait->image) }}" @endif><source src="{{ asset('storage/'.$portrait->video) }}"></video>
                                    </div>
                                @endif
                                @unless ($portrait->image || $portrait->video)
                                    <div class="gallery-media"><div class="gallery-placeholder">AbloArt</div></div>
                                @endunless
                                <div class="gallery-caption p-3"><p class="gallery-category mb-1">{{ $portrait->categorie?->nom ?? 'Portrait personnalisé' }}</p><p class="small text-secondary mb-0">{{ $portrait->description }}</p></div>
                            </article>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="gallery-empty"><span class="empty-mark">✦</span><h3>La galerie est en préparation.</h3><p>Votre portrait pourrait être la prochaine création.</p><a href="{{ route('demandes.create') }}" class="btn btn-coral">Demander un portrait</a></div>
            @endif
        </main>
    </body>
</html>
