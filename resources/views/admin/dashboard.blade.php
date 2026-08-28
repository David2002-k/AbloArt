<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - AbloArt</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <div class="container py-5">

        <h1>Dashboard AbloArt </h1>
        
        <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="btn btn-danger">
                    Déconnexion
                </button>
        </form>
        <p>
            Bienvenue,
            <strong>{{ auth()->user()->name }}</strong>
        </p>

        <div class="alert alert-success">
            Vous êtes connecté en tant qu'administrateur.
        </div>

    </div>

</body>
</html>