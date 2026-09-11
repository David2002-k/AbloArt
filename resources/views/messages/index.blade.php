<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contact | AbloArt</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="home-page">
        <nav class="navbar navbar-expand-lg home-navbar sticky-top">
            <div class="container">
                <a class="navbar-brand home-brand" href="{{ route('welcome') }}">Ablo<span>Art</span><i></i></a>
                <a class="btn btn-outline-dark btn-sm" href="{{ route('welcome') }}">Retour à l'accueil</a>
            </div>
        </nav>

        <main class="container py-5">
            <section class="activity-panel mx-auto max-w-3xl p-4 p-lg-5">
                <p class="eyebrow mb-2">Contactez l'atelier</p>
                <h1 class="hero-title mb-3">Parlons de votre<br><em>projet.</em></h1>
                <p class="text-secondary mb-4">Envoyez-nous votre demande. Nous vous répondrons rapidement.</p>

                @if (session('success'))
                    <div class="alert alert-success" role="status">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('messages.store') }}" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <label for="nom" class="form-label">Nom</label>
                        <input id="nom" name="nom" value="{{ old('nom') }}" required maxlength="100" class="form-control" type="text">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" value="{{ old('email') }}" required maxlength="150" class="form-control" type="email">
                    </div>
                    <div class="col-md-6">
                        <label for="telephone" class="form-label">Téléphone <span class="text-secondary">(facultatif)</span></label>
                        <input id="telephone" name="telephone" value="{{ old('telephone') }}" maxlength="30" class="form-control" type="tel">
                    </div>
                    <div class="col-md-6">
                        <label for="sujet" class="form-label">Sujet</label>
                        <input id="sujet" name="sujet" value="{{ old('sujet') }}" maxlength="150" class="form-control" type="text">
                    </div>
                    <div class="col-12">
                        <label for="message" class="form-label">Votre message</label>
                        <textarea id="message" name="message" required minlength="10" maxlength="5000" rows="6" class="form-control">{{ old('message') }}</textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-coral">Envoyer le message <span aria-hidden="true">↗</span></button>
                    </div>
                </form>
            </section>
        </main>
    </body>
</html>
