<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Témoignages | AbloArt</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="home-page">
        <nav class="navbar navbar-expand-lg home-navbar sticky-top">
            <div class="container">
                <a class="navbar-brand home-brand" href="{{ route('welcome') }}">Ablo<span>Art</span><i></i></a>
                <a class="btn btn-outline-dark btn-sm" href="{{ route('welcome') }}">Retour à l'accueil</a>
            </div>
        </nav>

        <main class="container testimonials-page py-5">
            <div class="testimonials-heading mb-5">
                <p class="eyebrow">Ils nous font confiance</p>
                <h1 class="hero-title">Les témoignages<br><em>de nos clients.</em></h1>
            </div>

            <div class="row g-4 align-items-start">
                <section id="testimonial-submission" class="col-12 col-lg-5" aria-labelledby="testimonial-form-title">
                    <div class="testimonial-form-panel h-100 p-4 p-lg-5">
                        <p class="eyebrow mb-2">Votre expérience</p>
                        <h2 id="testimonial-form-title" class="h3 mb-4">Partager un témoignage</h2>

                        @if (session('success'))
                            <div class="alert alert-success" role="status">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <p class="mb-1">Votre témoignage n'a pas pu être envoyé :</p>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('temoignages.store') }}" class="row g-3">
                            @csrf
                            <div class="col-12">
                                <label for="nom" class="form-label">Votre nom</label>
                                <input id="nom" name="nom" type="text" value="{{ old('nom') }}" class="form-control" maxlength="100" required>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Votre témoignage</label>
                                <textarea id="message" name="message" rows="6" maxlength="2000" class="form-control" required>{{ old('message') }}</textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-coral">Envoyer mon témoignage <span aria-hidden="true">↗</span></button>
                            </div>
                        </form>
                    </div>
                </section>

                <section id="published-testimonials" class="col-12 col-lg-7" aria-labelledby="published-testimonials-title">
                    <div class="testimonial-list-panel p-4 p-lg-5">
                        <p class="eyebrow mb-2">Ils nous font confiance</p>
                        <h2 id="published-testimonials-title" class="h3 mb-4">Témoignages publiés</h2>

                        <div class="testimonial-list">
                            @forelse ($temoignages as $temoignage)
                                <article class="testimonial-entry">
                                    <div class="stars" aria-label="5 étoiles">★★★★★</div>
                                    <blockquote class="mb-3">“{{ $temoignage->message }}”</blockquote>
                                    <footer>{{ $temoignage->nom }}</footer>
                                </article>
                            @empty
                                <div class="testimonial-empty">Aucun témoignage publié pour le moment.</div>
                            @endforelse
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </body>
</html>
