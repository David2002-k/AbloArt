<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-900">Détails de la catégorie</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                <p class="text-sm font-medium text-teal-700">Catégorie</p>
                <h3 class="mt-1 text-2xl font-semibold text-gray-900">{{ $categorie->nom }}</h3>
                <p class="mt-4 whitespace-pre-line text-gray-600">{{ $categorie->description ?: 'Aucune description.' }}</p>
                <p class="mt-6 text-sm text-gray-500">{{ $categorie->portraits()->count() }} portrait(s) associé(s)</p>
                <div class="mt-8 flex gap-3">
                    <a href="{{ route('admin.categories.edit', $categorie) }}" class="rounded-md bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-800 hover:bg-amber-200">Modifier</a>
                    <a href="{{ route('admin.categories.index') }}" class="rounded-md bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">Retour</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
