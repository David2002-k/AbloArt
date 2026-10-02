<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-teal-700">Retours clients</p>
                <h2 class="mt-1 text-2xl font-semibold leading-tight text-gray-900">Modération des témoignages</h2>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-md border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:border-teal-600 hover:text-teal-700">Retour au tableau de bord</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 sm:rounded-lg" role="status">{{ session('success') }}</div>
            @endif

            <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-5">
                    <p class="text-sm font-medium text-teal-700">À vérifier et à publier</p>
                    <h3 class="mt-1 text-xl font-semibold text-gray-900">{{ $temoignages->count() }} témoignage{{ $temoignages->count() === 1 ? '' : 's' }}</h3>
                </div>

                @forelse ($temoignages as $temoignage)
                    <article class="flex flex-col gap-4 border-b border-gray-100 px-6 py-5 last:border-b-0 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0 flex-1">
                            <div class="mb-2 flex flex-wrap items-center gap-2">
                                <h3 class="font-semibold text-gray-900">{{ $temoignage->nom }}</h3>
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $temoignage->publie ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ $temoignage->publie ? 'Publié' : 'En attente' }}
                                </span>
                            </div>
                            <p class="whitespace-pre-line text-sm leading-6 text-gray-600">{{ $temoignage->message }}</p>
                            <p class="mt-2 text-xs text-gray-400">Reçu le {{ $temoignage->created_at?->format('d/m/Y à H:i') }}</p>
                        </div>
                        <form method="POST" action="{{ route('admin.temoignages.update', $temoignage) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="publie" value="{{ $temoignage->publie ? '0' : '1' }}">
                            <button type="submit" class="inline-flex min-h-10 items-center justify-center rounded-md px-4 py-2 text-sm font-semibold text-white {{ $temoignage->publie ? 'bg-gray-700 hover:bg-gray-900' : 'bg-teal-700 hover:bg-teal-800' }}">
                                {{ $temoignage->publie ? 'Retirer du site' : 'Valider et publier' }}
                            </button>
                        </form>
                    </article>
                @empty
                    <div class="px-6 py-16 text-center">
                        <h3 class="text-lg font-semibold text-gray-800">Aucun témoignage reçu</h3>
                        <p class="mt-2 text-sm text-gray-500">Les nouveaux témoignages apparaîtront ici pour validation.</p>
                    </div>
                @endforelse
            </section>
        </div>
    </div>
</x-app-layout>