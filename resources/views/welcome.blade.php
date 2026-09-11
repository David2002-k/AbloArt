<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AbloArt | Accueil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="home-header">
        <div class="home-header-inner container mx-auto flex flex-wrap items-center gap-4 px-4 py-3">
            <a href="{{ route('welcome') }}" class="home-brand-block order-1 flex items-center gap-3" aria-label="AbloArt, accueil">
                @if ($admin?->photo)
                    <img src="{{ asset('storage/'.$admin->photo) }}" alt="Photo de {{ $admin->user?->name ?? 'AbloArt' }}" class="h-11 w-11 rounded-full object-cover ring-2 ring-teal-100">
                @else
                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-teal-700 text-lg font-semibold text-white" aria-hidden="true">A</span>
                @endif
                <span class="flex max-w-xs flex-col">
                    <span class="home-brand-kicker">Studio · Portraits</span>
                    <span class="home-wordmark">Ablo<span>Art</span><i></i></span>
                    @if ($admin?->biographie)
                        <span class="mt-1 max-w-xs truncate text-xs text-gray-500" title="{{ $admin->biographie }}">{{ $admin->biographie }}</span>
                    @endif
                </span>
            </a>
            <nav class="order-2 ml-auto flex flex-wrap items-center justify-end gap-1" aria-label="Navigation principale">
                <a href="{{ route('a-propos.index') }}" class="home-nav-link">À propos de nous</a>
                <a href="{{ route('galerie.index') }}" class="home-nav-link">Galerie</a>
                <a href="{{ route('demandes.create') }}" class="home-nav-link home-nav-link-primary">Demander un portrait</a>
                <a href="{{ route('temoignages.index') }}" class="home-nav-link">Témoignages</a>
                <a href="{{ route('messages.index') }}" class="home-nav-link">Contactez-nous</a>
                <a href="{{ route('login') }}" class="home-nav-link home-nav-link-login">Se connecter</a>
            </nav>
        </div>
    </header>
    <main class="container mx-auto px-4 py-20">
        <section class="mx-auto max-w-5xl py-16 text-center">
            <div>
                <p class="mb-3 text-sm font-semibold uppercase tracking-widest text-teal-700">Atelier de portraits</p>
                <h1 class="mb-5 text-5xl font-bold text-gray-900">Bienvenue chez AbloArt</h1>
                <p class="mx-auto mb-8 max-w-2xl text-lg text-gray-600">Des créations uniques pour donner une présence durable à vos souvenirs.</p>
                <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('galerie.index') }}" class="rounded-md bg-teal-700 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-900">Découvrir la galerie</a>
                <a href="{{ route('demandes.create') }}" class="rounded-md border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 hover:border-teal-700 hover:text-teal-700">Demander un portrait</a>
                <a href="{{ route('temoignages.index') }}" class="rounded-md bg-gray-900 px-5 py-3 text-sm font-semibold text-white hover:bg-teal-700">Voir les témoignages</a>
                </div>
            </div>
        </section>
    </main>

    <section class="border-y border-gray-200 bg-gray-50 px-4 py-12">
        <div class="mx-auto max-w-5xl">
            <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-widest text-teal-700">Galerie</p>
                    <h2 class="text-3xl font-bold text-gray-900">Quelques portraits récents</h2>
                </div>
                <a href="{{ route('galerie.index') }}" class="text-sm font-semibold text-teal-700 hover:text-gray-900">Voir toute la galerie ↗</a>
            </div>

            @if ($portraits->isNotEmpty())
                <div id="homePortraitCarousel" class="carousel slide portrait-carousel vertical-carousel" data-bs-ride="carousel" data-bs-interval="4500">
                    <div class="carousel-indicators">
                        @foreach ($portraits as $portrait)
                            <button type="button" data-bs-target="#homePortraitCarousel" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-label="Portrait {{ $loop->iteration }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach ($portraits as $portrait)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <div class="mx-auto max-w-sm overflow-hidden rounded-lg bg-white shadow-sm">
                                    <div class="gallery-media">
                                        @if ($portrait->video)
                                            <video controls preload="metadata" poster="{{ $portrait->image ? asset('storage/'.$portrait->image) : '' }}"><source src="{{ asset('storage/'.$portrait->video) }}"></video>
                                        @elseif ($portrait->image)
                                            <img src="{{ asset('storage/'.$portrait->image) }}" alt="Portrait {{ $portrait->categorie?->nom ?? 'AbloArt' }}" loading="lazy">
                                        @else
                                            <div class="gallery-placeholder">AbloArt</div>
                                        @endif
                                    </div>
                                    <div class="p-3"><p class="mb-1 font-semibold text-gray-900">{{ $portrait->categorie?->nom ?? 'Portrait personnalisé' }}</p><p class="mb-0 text-sm text-gray-600">{{ $portrait->description }}</p></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($portraits->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#homePortraitCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Précédent</span></button>
                        <button class="carousel-control-next" type="button" data-bs-target="#homePortraitCarousel" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Suivant</span></button>
                    @endif
                </div>
            @else
                <p class="rounded-lg border border-dashed border-gray-300 bg-white p-8 text-center text-gray-500">Les portraits publiés apparaîtront ici.</p>
            @endif
        </div>
    </section>

    <section class="border-t border-gray-200 bg-white px-4 py-10">
        <div class="mx-auto max-w-4xl">
            <div class="mb-5 flex flex-wrap items-end justify-between gap-3">
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-widest text-teal-700">Contact rapide</p>
                    <h2 class="text-2xl font-bold text-gray-900">Une question ? Écrivez-nous.</h2>
                </div>
                <a href="{{ route('messages.index') }}" class="text-sm text-gray-500 hover:text-teal-700">Plus d'informations ↗</a>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-3 text-sm text-green-800" role="status">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-md bg-red-100 p-3 text-sm text-red-800" role="alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('messages.store') }}" class="grid gap-3 md:grid-cols-[1fr_1fr_2fr_auto] md:items-end">
                @csrf
                <div>
                    <label for="nom" class="mb-1 block text-xs font-medium text-gray-600">Nom</label>
                    <input id="nom" name="nom" value="{{ old('nom') }}" required maxlength="100" class="w-full rounded-md border-gray-300 text-sm shadow-sm" type="text">
                </div>
                <div>
                    <label for="email" class="mb-1 block text-xs font-medium text-gray-600">Email</label>
                    <input id="email" name="email" value="{{ old('email') }}" required maxlength="150" class="w-full rounded-md border-gray-300 text-sm shadow-sm" type="email">
                </div>
                <div>
                    <label for="message" class="mb-1 block text-xs font-medium text-gray-600">Message</label>
                    <input id="message" name="message" required minlength="10" maxlength="5000" class="w-full rounded-md border-gray-300 text-sm shadow-sm" type="text">
                </div>
                <button type="submit" class="rounded-md bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-teal-700">Envoyer</button>
            </form>
        </div>
    </section>

    <footer class="border-t border-gray-200 bg-gray-900 px-4 py-10 text-white">
        <div class="mx-auto grid max-w-5xl gap-8 md:grid-cols-3">
            <div>
                <a href="{{ route('welcome') }}" class="home-wordmark text-white" aria-label="AbloArt, accueil">Ablo<span>Art</span><i></i></a>
                <p class="mt-3 max-w-xs text-sm leading-6 text-gray-300">Des portraits sensibles et personnalisés, réalisés avec soin par AbloArt.</p>
                @if ($admin?->cv)
                    <a href="{{ route('profile.cv') }}" class="mt-4 inline-block text-sm text-teal-300 hover:text-white">Télécharger le CV d'AbloArt ↗</a>
                @endif
            </div>

            <div>
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-widest text-teal-300">Nous contacter</h2>
                <div class="space-y-2 text-sm text-gray-300">
                    <a href="mailto:{{ $admin?->user?->email ?? 'bonjour@abloart.fr' }}" class="block hover:text-white">Email : {{ $admin?->user?->email ?? 'bonjour@abloart.fr' }}</a>
                    @if ($admin?->telephone)
                        <a href="tel:{{ $admin->telephone }}" class="block hover:text-white">Téléphone : {{ $admin->telephone }}</a>
                    @endif
                    @if ($admin?->adresse)
                        <p class="mb-0">Adresse : {{ $admin->adresse }}</p>
                    @endif
                </div>
            </div>

            <div>
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-widest text-teal-300">Nos réseaux sociaux</h2>
                <div class="flex flex-wrap gap-2">
                    @forelse ($reseaux as $reseau)
                        <a href="{{ $reseau->url }}" target="_blank" rel="noopener noreferrer" class="rounded-md border border-gray-600 px-3 py-2 text-sm text-gray-200 hover:border-teal-300 hover:text-white">
                            {{ $reseau->icone ?: $reseau->nom }}
                        </a>
                    @empty
                        <span class="text-sm text-gray-400">Réseaux sociaux bientôt disponibles.</span>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="mx-auto mt-8 max-w-5xl border-t border-gray-700 pt-4 text-xs text-gray-400">© {{ date('Y') }} AbloArt. Tous droits réservés.</div>
    </footer>
</body>
</html>