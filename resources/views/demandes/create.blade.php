<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Demander un portrait | AbloArt</title>
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
            <section class="activity-panel mx-auto p-4 p-lg-5" style="max-width: 760px;">
                <p class="eyebrow mb-2">Votre projet</p>
                <h1 class="hero-title mb-3">Demander un<br><em>portrait.</em></h1>
                <p class="text-secondary mb-4">Décrivez votre idée. L'atelier vous répondra avec une proposition personnalisée.</p>
                @if (session('success'))<div class="alert alert-success" role="status">{{ session('success') }}</div>@endif
                @if ($errors->any())<div class="alert alert-danger" role="alert"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <form method="POST" action="{{ route('demandes.store') }}" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    <div class="col-md-6"><label for="nom" class="form-label">Nom</label><input id="nom" name="nom" value="{{ old('nom') }}" required maxlength="100" class="form-control" type="text"></div>
                    <div class="col-md-6"><label for="email" class="form-label">Email</label><input id="email" name="email" value="{{ old('email') }}" required maxlength="150" class="form-control" type="email"></div>
                    <div class="col-md-6"><label for="telephone" class="form-label">Téléphone</label><input id="telephone" name="telephone" value="{{ old('telephone') }}" maxlength="30" class="form-control" type="tel"></div>
                    <div class="col-md-6"><label for="photo_reference" class="form-label">Photo de référence</label><input id="photo_reference" name="photo_reference" accept="image/jpeg,image/png,image/webp" class="form-control" type="file"></div>
                    <div class="col-12"><label for="description" class="form-label">Décrivez votre projet</label><textarea id="description" name="description" required minlength="10" maxlength="5000" rows="6" class="form-control">{{ old('description') }}</textarea></div>
                    <div class="col-12"><button type="submit" class="btn btn-coral">Envoyer ma demande <span aria-hidden="true">↗</span></button></div>
                </form>
            </section>
        </main>
    </body>
</html>
