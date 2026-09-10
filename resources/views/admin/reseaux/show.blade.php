<x-app-layout>
    <x-slot name="header"><h2 class="text-2xl font-semibold text-gray-900">Détails du réseau social</h2></x-slot>
    <div class="py-12"><div class="max-w-2xl mx-auto sm:px-6 lg:px-8"><div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
        <p class="text-sm font-medium text-teal-700">Réseau social</p><h3 class="mt-1 text-2xl font-semibold text-gray-900">{{ $reseau->nom }}</h3>
        <a href="{{ $reseau->url }}" target="_blank" rel="noopener" class="mt-4 block text-teal-700 hover:underline">{{ $reseau->url }}</a>
        <p class="mt-4 text-sm text-gray-500">Statut : {{ $reseau->actif ? 'Actif' : 'Masqué' }}</p>
        <div class="mt-8 flex gap-3"><a href="{{ route('admin.reseaux.edit', $reseau) }}" class="rounded-md bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-800 hover:bg-amber-200">Modifier</a><a href="{{ route('admin.reseaux.index') }}" class="rounded-md bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">Retour</a></div>
    </div></div></div>
</x-app-layout>
