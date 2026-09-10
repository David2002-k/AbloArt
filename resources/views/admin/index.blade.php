<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-teal-700">Galerie</p>
                <h2 class="mt-1 text-2xl font-semibold text-gray-900 leading-tight">
                    Gestion des portraits
                </h2>
            </div>

            <a href="{{ route('admin.portraits.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-md bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-2">
                <span class="text-lg leading-none">+</span>
                Ajouter un portrait
            </a>
        </div>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto space-y-6 sm:px-6 lg:px-8">

            {{-- Message de succès --}}
            @if (session('success'))
                <div class="border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 shadow-sm sm:rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="flex flex-col gap-3 border-b border-gray-100 px-6 py-5 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-medium text-teal-700">Votre collection</p>
                        <h3 class="mt-1 text-xl font-semibold text-gray-900">
                            Mes portraits
                        </h3>
                    </div>
                    <p class="text-sm text-gray-500">
                        {{ $portraits->count() }} portrait{{ $portraits->count() > 1 ? 's' : '' }} publié{{ $portraits->count() > 1 ? 's' : '' }}
                    </p>
                </div>

                @if ($portraits->count() > 0)

                    <div class="overflow-x-auto">

                        <table class="w-full min-w-[860px] border-collapse text-left">

                            <thead>
                                <tr class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">

                                    <th class="border-b border-gray-200 px-4 py-3 font-semibold">
                                        Image
                                    </th>

                                    <th class="border-b border-gray-200 px-4 py-3 font-semibold">
                                        Catégorie
                                    </th>

                                    <th class="border-b border-gray-200 px-4 py-3 font-semibold">
                                        Description
                                    </th>

                                    <th class="border-b border-gray-200 px-4 py-3 font-semibold">
                                        Date
                                    </th>

                                    <th class="border-b border-gray-200 px-4 py-3 font-semibold">
                                        Vidéo
                                    </th>

                                    <th class="border-b border-gray-200 px-4 py-3 font-semibold">
                                        Actions
                                    </th>

                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($portraits as $portrait)

                                    <tr class="border-b border-gray-100 transition hover:bg-teal-50/40">

                                        {{-- Image --}}
                                        <td class="px-4 py-4">

                                            @if ($portrait->image)

                                                <img
                                                    src="{{ asset('storage/' . $portrait->image) }}"
                                                    alt="Portrait"
                                                    class="h-16 w-20 rounded-lg object-cover shadow-sm ring-1 ring-gray-200"
                                                >

                                            @else

                                                <span class="text-gray-400">
                                                    Aucune image
                                                </span>

                                            @endif

                                        </td>

                                        {{-- Catégorie --}}
                                        <td class="px-4 py-4">
                                            <span class="rounded-full bg-teal-50 px-2.5 py-1 text-xs font-medium text-teal-700">
                                                {{ $portrait->categorie->nom ?? 'Sans catégorie' }}
                                            </span>
                                        </td>

                                        {{-- Description --}}
                                        <td class="max-w-xs px-4 py-4 text-sm leading-6 text-gray-600">
                                            {{ Str::limit($portrait->description, 80) ?: 'Aucune description' }}
                                        </td>

                                        {{-- Date --}}
                                        <td class="px-4 py-4 text-sm text-gray-600">
                                            {{ $portrait->date_realisation?->format('d/m/Y') ?? '-' }}
                                        </td>

                                        {{-- Vidéo --}}
                                        <td class="px-4 py-4">

                                            @if ($portrait->video)

                                                <span class="inline-flex items-center gap-1.5 text-sm font-medium text-emerald-700">
                                                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                                    ✓ Disponible
                                                </span>

                                            @else

                                                <span class="text-sm text-gray-400">
                                                    Aucune
                                                </span>

                                            @endif

                                        </td>

                                        {{-- Actions --}}
                                        <td class="px-4 py-4">

                                            <div class="flex flex-wrap gap-2">

                                                {{-- Voir --}}
                                                <a
                                                    href="{{ route('admin.portraits.show', $portrait) }}"
                                                    class="rounded-md border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-700 transition hover:border-teal-600 hover:text-teal-700"
                                                >
                                                    Voir
                                                </a>

                                                {{-- Modifier --}}
                                                <a
                                                    href="{{ route('admin.portraits.edit', $portrait) }}"
                                                    class="rounded-md bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-800 transition hover:bg-amber-200"
                                                >
                                                    Modifier
                                                </a>

                                                {{-- Supprimer --}}
                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.portraits.destroy', $portrait) }}"
                                                    onsubmit="return confirm('Voulez-vous vraiment supprimer ce portrait ?');"
                                                >

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="rounded-md bg-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-200"
                                                    >
                                                        Supprimer
                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="px-6 py-16 text-center">

                        <div class="text-5xl mb-4">
                            
                        </div>

                        <h4 class="text-xl font-semibold text-gray-800">
                            Aucun portrait pour le moment
                        </h4>

                        <p class="text-gray-500 mt-2">
                            Commencez par ajouter votre premier portrait.
                        </p>

                        <a
                            href="{{ route('admin.portraits.create') }}"
                            class="mt-5 inline-flex rounded-md bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-teal-700"
                        >
                            Ajouter un portrait
                        </a>

                    </div>

                @endif

            </div>

            <div class="flex flex-col gap-3 rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-gray-600">Vous souhaitez enrichir votre galerie ?</p>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center rounded-md bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-200">
                        Retour au dashboard
                    </a>
                    <a href="{{ route('admin.portraits.create') }}" class="inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-teal-700">
                        + Ajouter un portrait
                    </a>
                </div>
            </div>

        </div>

    </div>

</x-app-layout>