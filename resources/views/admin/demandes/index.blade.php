<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-teal-700">Contact</p>
                <h2 class="mt-1 text-2xl font-semibold text-gray-900 leading-tight">
                    Demandes de portraits
                </h2>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center justify-center rounded-md border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:border-teal-600 hover:text-teal-700">
                Retour au dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto space-y-6 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="flex flex-col gap-4 border-b border-gray-100 px-6 py-5 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-medium text-teal-700">Boîte de réception</p>
                        <h3 class="mt-1 text-xl font-semibold text-gray-900">
                            {{ $demandes->count() }} demande{{ $demandes->count() > 1 ? 's' : '' }}
                        </h3>
                    </div>

                    <form method="GET" action="{{ route('admin.demandes.index') }}" class="flex items-end gap-2">
                        <div>
                            <label for="statut" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Filtrer par statut
                            </label>
                            <select id="statut" name="statut" class="rounded-md border-gray-300 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                                <option value="">Toutes les demandes</option>
                                <option value="en_attente" @selected($status === 'en_attente')>En attente</option>
                                <option value="acceptee" @selected($status === 'acceptee')>Acceptées</option>
                                <option value="refusee" @selected($status === 'refusee')>Refusées</option>
                                <option value="terminee" @selected($status === 'terminee')>Terminées</option>
                            </select>
                        </div>
                        <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-teal-700">
                            Filtrer
                        </button>
                    </form>
                </div>

                @if ($demandes->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[920px] border-collapse text-left">
                            <thead>
                                <tr class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                                    <th class="border-b border-gray-200 px-4 py-3 font-semibold">Demandeur</th>
                                    <th class="border-b border-gray-200 px-4 py-3 font-semibold">Contact</th>
                                    <th class="border-b border-gray-200 px-4 py-3 font-semibold">Description</th>
                                    <th class="border-b border-gray-200 px-4 py-3 font-semibold">Photo</th>
                                    <th class="border-b border-gray-200 px-4 py-3 font-semibold">Statut</th>
                                    <th class="border-b border-gray-200 px-4 py-3 font-semibold">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($demandes as $demande)
                                    @php
                                        $statusClasses = [
                                            'en_attente' => 'bg-amber-50 text-amber-700',
                                            'acceptee' => 'bg-emerald-50 text-emerald-700',
                                            'refusee' => 'bg-rose-50 text-rose-700',
                                            'terminee' => 'bg-sky-50 text-sky-700',
                                        ];
                                        $statusLabels = [
                                            'en_attente' => 'En attente',
                                            'acceptee' => 'Acceptée',
                                            'refusee' => 'Refusée',
                                            'terminee' => 'Terminée',
                                        ];
                                    @endphp
                                    <tr class="border-b border-gray-100 transition hover:bg-teal-50/40">
                                        <td class="px-4 py-4 align-top">
                                            <p class="font-semibold text-gray-900">{{ $demande->nom }}</p>
                                            <p class="mt-1 text-sm text-gray-500">Demande #{{ $demande->id }}</p>
                                        </td>
                                        <td class="px-4 py-4 align-top text-sm text-gray-600">
                                            <a href="mailto:{{ $demande->email }}" class="font-medium text-teal-700 hover:underline">{{ $demande->email }}</a>
                                            @if ($demande->telephone)
                                                <p class="mt-1">{{ $demande->telephone }}</p>
                                            @endif
                                        </td>
                                        <td class="max-w-sm px-4 py-4 align-top text-sm leading-6 text-gray-600">
                                            {{ Str::limit($demande->description, 120) }}
                                        </td>
                                        <td class="px-4 py-4 align-top">
                                            @if ($demande->photo_reference)
                                                <a href="{{ asset('storage/' . $demande->photo_reference) }}" target="_blank" class="text-sm font-semibold text-teal-700 hover:underline">
                                                    Voir la photo
                                                </a>
                                            @else
                                                <span class="text-sm text-gray-400">Aucune</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 align-top">
                                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClasses[$demande->statut] ?? 'bg-gray-100 text-gray-600' }}">
                                                {{ $statusLabels[$demande->statut] ?? ucfirst($demande->statut) }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 align-top text-sm text-gray-600">
                                            {{ $demande->created_at?->format('d/m/Y') ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="px-6 py-16 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-teal-50 text-2xl text-teal-700">✦</div>
                        <h4 class="mt-5 text-xl font-semibold text-gray-800">Aucune demande trouvée</h4>
                        <p class="mt-2 text-gray-500">Les nouvelles demandes de portraits apparaîtront ici.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
