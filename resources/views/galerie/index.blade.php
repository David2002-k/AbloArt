<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Galerie | AbloArt</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="home-page">
        <nav class="navbar home-navbar sticky-top">
            <div class="container d-flex justify-content-between">
                <a class="navbar-brand home-brand" href="{{ route('welcome') }}">Ablo<span>Art</span><i></i></a>
                <a class="btn btn-outline-dark btn-sm" href="{{ route('welcome') }}">Retour à l'accueil</a>
            </div>
        </nav>
        <main class="container py-5">
            <div class="mb-5">
                <p class="eyebrow">Les créations AbloArt</p>
                <h1 class="hero-title">Une galerie de<br><em>portraits uniques.</em></h1>
            </div>
            @if ($portraits->isNotEmpty())
                <div id="portraitCarousel" class="carousel slide portrait-carousel" data-bs-ride="carousel" data-bs-interval="4500">
                    <div class="carousel-indicators">
                        @foreach ($portraits as $portrait)
                            <button type="button" data-bs-target="#portraitCarousel" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" aria-label="Portrait {{ $loop->iteration }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach ($portraits as $portrait)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <article class="testimonial-card mx-auto p-0 overflow-hidden">
                                    <div class="gallery-media">
                                        @if ($portrait->video)
                                            <video controls preload="metadata" poster="{{ $portrait->image ? asset('storage/'.$portrait->image) : '' }}"><source src="{{ asset('storage/'.$portrait->video) }}"></video>
                                        @elseif ($portrait->image)
                                            <img src="{{ asset('storage/'.$portrait->image) }}" alt="Portrait {{ $portrait->categorie?->nom ?? 'AbloArt' }}" loading="lazy">
                                        @else
                                            <div class="gallery-placeholder">AbloArt</div>
                                        @endif
                                    </div>
                                    <div class="p-3"><p class="mb-1 fw-semibold">{{ $portrait->categorie?->nom ?? 'Portrait personnalisé' }}</p><p class="small text-secondary mb-0">{{ $portrait->description }}</p></div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                    @if ($portraits->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#portraitCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Précédent</span></button>
                        <button class="carousel-control-next" type="button" data-bs-target="#portraitCarousel" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Suivant</span></button>
                    @endif
                </div>
            @else
                <div class="gallery-empty"><span class="empty-mark">✦</span><h3>La galerie est en préparation.</h3><p>Votre portrait pourrait être la prochaine création.</p><a href="{{ route('demandes.create') }}" class="btn btn-coral">Demander un portrait</a></div>
            @endif
        </main>
    </body>
</html>
