<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - AbloArt</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="dashboard-shell">
    <nav class="dashboard-nav navbar navbar-expand-lg">
        <div class="container py-3">
            <a class="brand-mark navbar-brand" href="{{ route('admin.dashboard') }}">Ablo<span>Art</span></a>
            <div class="d-flex align-items-center gap-3 ms-auto">
                <span class="d-none d-sm-inline text-secondary">{{ auth()->user()->email }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-dark btn-sm">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <section class="mb-5">
            <p class="eyebrow mb-3">Espace administration</p>
            <h1 class="hero-title mb-3">Bonjour, <em>{{ auth()->user()->name }}</em>.</h1>
            <p class="lead text-secondary mb-0">Pilotez votre univers artistique depuis un seul espace.</p>
        </section>

        <section class="row g-4 mb-5" aria-label="Statistiques du site">
            <div class="col-12 col-md-4">
                <article class="stat-card h-100 p-4">
                    <p class="stat-label mb-4">Portraits publiés</p>
                    <p class="stat-value mb-2">{{ \App\Models\Portrait::count() }}</p>
                    <span class="text-success small">Votre galerie en ligne</span>
                </article>
            </div>
            <div class="col-12 col-md-4">
                <article class="stat-card h-100 p-4">
                    <p class="stat-label mb-4">Demandes reçues</p>
                    <p class="stat-value mb-2">{{ \App\Models\DemandePortrait::count() }}</p>
                    <span class="text-secondary small">À traiter depuis votre espace</span>
                </article>
            </div>
            <div class="col-12 col-md-4">
                <article class="stat-card h-100 p-4">
                    <p class="stat-label mb-4">Témoignages</p>
                    <p class="stat-value mb-2">{{ \App\Models\Temoignage::count() }}</p>
                    <span class="text-secondary small">La voix de vos clients</span>
                </article>
            </div>
        </section>

        <section class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-7">
                <div class="activity-panel h-100 p-4 p-lg-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">Bienvenue dans votre atelier</h2>
                        <span class="badge rounded-pill text-bg-success">En ligne</span>
                    </div>
                    <p class="text-secondary mb-4">Votre espace est prêt. Commencez par enrichir votre galerie ou consultez les dernières demandes de portraits.</p>
                    <button class="btn btn-coral px-4" type="button" data-bs-toggle="collapse" data-bs-target="#quickActions" aria-expanded="false" aria-controls="quickActions">Afficher les actions rapides</button>
                    <div class="collapse mt-4" id="quickActions">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#" class="btn btn-outline-dark">Gérer les portraits</a>
                            <a href="#" class="btn btn-outline-dark">Voir les demandes</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="activity-panel h-100 p-4 p-lg-5">
                    <p class="eyebrow mb-3">Activité récente</p>
                    <div class="activity-item d-flex gap-3 py-3">
                        <span class="activity-dot rounded-circle flex-shrink-0 mt-2"></span>
                        <div><strong>Session ouverte</strong><p class="text-secondary small mb-0">Vous êtes connecté en tant qu’administrateur.</p></div>
                    </div>
                    <div class="activity-item d-flex gap-3 py-3">
                        <span class="activity-dot rounded-circle flex-shrink-0 mt-2"></span>
                        <div><strong>Tableau de bord prêt</strong><p class="text-secondary small mb-0">Les données sont synchronisées.</p></div>
                    </div>
                </div>
            </div>
        </section>
    </main>

</body>
</html>