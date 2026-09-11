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
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-dark btn-sm d-inline-flex align-items-center" aria-label="Modifier mes informations" title="Modifier mes informations">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M12.854.146a.5.5 0 0 0-.708 0L3 9.293V13h3.707l9.146-9.146a.5.5 0 0 0 0-.708l-3-3zM4 10l7.5-7.5 2 2L6 12H4v-2z" />
                        <path fill-rule="evenodd" d="M1.5 15a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 1 0V14h2.5a.5.5 0 0 1 0 1h-3z" />
                    </svg>
                    <span class="visually-hidden">Modifier mes informations</span>
                </a>
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

        <section class="dashboard-summary row g-3 mb-5" aria-label="Statistiques du site">
            <div class="col-12 col-sm-6 col-lg-3">
                <article class="stat-card h-100 p-3">
                    <p class="stat-label mb-2">Portraits publiés</p>
                    <p class="stat-value mb-1">{{ $portraitCount }}</p>
                    <span class="text-success small">Votre galerie en ligne</span>
                </article>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <article class="stat-card h-100 p-3">
                    <p class="stat-label mb-2">Demandes reçues</p>
                    <p class="stat-value mb-1">{{ $requestCount }}</p>
                    <span class="text-secondary small">À traiter depuis votre espace</span>
                </article>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <article class="stat-card h-100 p-3">
                    <p class="stat-label mb-2">Témoignages</p>
                    <p class="stat-value mb-1">{{ $testimonialCount }}</p>
                    <span class="text-secondary small">La voix de vos clients</span>
                </article>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <article class="stat-card h-100 p-3">
                    <p class="stat-label mb-2">Messages non lus</p>
                    <p class="stat-value mb-1">{{ $unreadMessagesCount }}</p>
                    <span class="text-secondary small">À consulter rapidement</span>
                </article>
            </div>
        </section>

        <section class="row g-4 mb-4" aria-label="Diagrammes statistiques">
            <div class="col-12 col-lg-7">
                <article class="activity-panel h-100 p-4 p-lg-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div><p class="eyebrow mb-2">Répartition</p><h2 class="h5 mb-0">Portraits par catégorie</h2></div>
                        <span class="chart-badge">{{ $portraitCount }} total</span>
                    </div>
                    @php($categoryMax = max(1, $portraitCategories->max('count')))
                    <div class="chart-bars">
                        @forelse ($portraitCategories as $category)
                            <div class="chart-bar-row"><div class="chart-bar-label">{{ $category['name'] }}<strong>{{ $category['count'] }}</strong></div><div class="chart-bar-track"><span style="width: {{ ($category['count'] / $categoryMax) * 100 }}%"></span></div></div>
                        @empty
                            <p class="text-secondary small mb-0">Ajoutez des catégories et des portraits pour voir le diagramme.</p>
                        @endforelse
                    </div>
                </article>
            </div>
            <div class="col-12 col-lg-5">
                <article class="activity-panel h-100 p-4 p-lg-5">
                    <p class="eyebrow mb-2">Suivi de l'activité</p>
                    <h2 class="h5 mb-4">Demandes et messages</h2>
                    <div class="status-chart">
                        <div class="status-chart-ring" style="--chart-total: {{ max(1, $requestStatuses->sum() + $messageStatuses->sum()) }}; --request-value: {{ $requestStatuses->sum() }}; --message-value: {{ $messageStatuses->sum() }}"><span>{{ $requestStatuses->sum() + $messageStatuses->sum() }}<small> éléments</small></span></div>
                        <div class="status-legend"><p><i class="legend-dot legend-request"></i>Demandes <strong>{{ $requestStatuses->sum() }}</strong></p><p><i class="legend-dot legend-message"></i>Messages <strong>{{ $messageStatuses->sum() }}</strong></p></div>
                    </div>
                    <div class="status-list mt-4">
                        @foreach ($requestStatuses as $label => $count)<span>{{ $label }} <strong>{{ $count }}</strong></span>@endforeach
                        @foreach ($messageStatuses as $label => $count)<span>{{ $label }} <strong>{{ $count }}</strong></span>@endforeach
                    </div>
                </article>
            </div>
        </section>

        <section class="activity-panel p-4 p-lg-5 mb-4" aria-labelledby="messages-title">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <p class="eyebrow mb-2">Boîte de réception</p>
                    <h2 id="messages-title" class="h4 mb-0">Messages des visiteurs</h2>
                </div>
                <span class="badge rounded-pill text-bg-light">{{ $messages->count() }} récent(s)</span>
            </div>

            @forelse ($messages as $message)
                <article class="message-card d-flex flex-column flex-lg-row justify-content-between gap-4 py-4">
                    <div class="flex-grow-1">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                            <h3 class="h6 mb-0">{{ $message->nom }}</h3>
                            <span class="badge rounded-pill {{ $message->statut === 'non_lu' ? 'text-bg-warning' : ($message->statut === 'traite' ? 'text-bg-success' : 'text-bg-secondary') }}">
                                {{ str_replace('_', ' ', ucfirst($message->statut)) }}
                            </span>
                        </div>
                        <p class="small text-secondary mb-2">
                            {{ $message->email }}
                            @if ($message->telephone)
                                <span class="mx-1">·</span>{{ $message->telephone }}
                            @endif
                            <span class="mx-1">·</span>{{ $message->created_at->format('d/m/Y à H:i') }}
                        </p>
                        @if ($message->sujet)
                            <p class="fw-semibold mb-1">{{ $message->sujet }}</p>
                        @endif
                        <p class="text-secondary mb-0">{{ $message->message }}</p>
                    </div>
                    <div class="d-flex flex-wrap align-items-start gap-2">
                        <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: '.($message->sujet ?: 'Votre message à AbloArt')) }}" class="btn btn-sm btn-coral">Répondre par email</a>
                        @if ($message->telephone)
                            <a href="tel:{{ $message->telephone }}" class="btn btn-sm btn-outline-dark">Appeler</a>
                        @endif
                    </div>
                </article>
            @empty
                <div class="empty-dashboard-state">
                    <p class="mb-1">Aucun message reçu pour le moment.</p>
                    <span class="small text-secondary">Les messages envoyés depuis le site apparaîtront ici.</span>
                </div>
            @endforelse
        </section>

        <section class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-7">
                <div class="activity-panel h-100 p-4 p-lg-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">Bienvenue dans votre atelier</h2>
                        <span class="badge rounded-pill text-bg-success">En ligne</span>
                    </div>
                    <p class="text-secondary mb-4">Votre espace est prêt. Commencez par enrichir votre galerie ou consultez les dernières demandes de portraits.</p>
                    <div x-data="{ open: false }" class="mt-4">
                        <button
                            class="btn btn-coral px-4"
                            type="button"
                            @click="open = !open"
                            :aria-expanded="open.toString()"
                            aria-controls="quickActions"
                        >
                            <span x-text="open ? 'Masquer les actions rapides' : 'Afficher les actions rapides'"></span>
                        </button>
                        <div x-show="open" x-transition id="quickActions" class="mt-4" aria-label="Actions rapides">
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('admin.portraits.index') }}" class="btn btn-outline-dark">Gérer les portraits</a>
                                <a href="{{ route('admin.portraits.create') }}" class="btn btn-coral">Ajouter un portrait</a>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark">Gérer les catégories</a>
                                <a href="{{ route('admin.reseaux.index') }}" class="btn btn-outline-dark">Gérer les réseaux sociaux</a>
                                <a href="{{ route('admin.demandes.index') }}" class="btn btn-outline-dark">Voir les demandes</a>
                            </div>
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