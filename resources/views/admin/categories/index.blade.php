<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-teal-700">Organisation</p>
                <h2 class="mt-1 text-2xl font-semibold text-gray-900">Gestion des catégories</h2>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center justify-center gap-2 rounded-md bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-teal-700">
                <span class="text-lg leading-none">+</span>
                Ajouter une catégorie
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto space-y-6 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">{{ session('error') }}</div>
            @endif

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-5">
                    <p class="text-sm font-medium text-teal-700">Votre classement</p>
                    <h3 class="mt-1 text-xl font-semibold text-gray-900">{{ $categories->count() }} catégorie{{ $categories->count() > 1 ? 's' : '' }}</h3>
                </div>

                @if ($categories->isNotEmpty())
                    <div class="divide-y divide-gray-100">
                        @foreach ($categories as $categorie)
                            <div class="flex flex-col gap-4 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $categorie->nom }}</h4>
                                    <p class="mt-1 text-sm text-gray-500">{{ $categorie->description ?: 'Aucune description' }}</p>
                                    <p class="mt-2 text-xs font-medium uppercase tracking-wide text-teal-700">{{ $categorie->portraits_count }} portrait{{ $categorie->portraits_count > 1 ? 's' : '' }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.categories.edit', $categorie) }}" class="rounded-md bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-800 transition hover:bg-amber-200">Modifier</a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $categorie) }}" onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md bg-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-200">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="px-6 py-16 text-center">
                        <h4 class="text-xl font-semibold text-gray-800">Aucune catégorie</h4>
                        <p class="mt-2 text-gray-500">Créez une catégorie pour organiser vos portraits.</p>
                    </div>
                @endif
            </div>

            <div class="flex flex-col gap-3 rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-gray-600">Organisez vos portraits avec de nouvelles catégories.</p>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center rounded-md bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-200">
                        Retour au dashboard
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-teal-700">
                        + Ajouter une catégorie
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
